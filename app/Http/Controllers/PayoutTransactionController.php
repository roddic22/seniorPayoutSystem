<?php

namespace App\Http\Controllers;

use App\Models\PayoutTransaction;
use App\Models\PayoutCycle;
use App\Models\PayoutSchedule;
use App\Models\Senior;
use App\Models\Counter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\StoreTransactionRequest;

class PayoutTransactionController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $transactions = PayoutTransaction::with([
            'senior.barangay', 'cycle', 'counter', 'schedule'
        ])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('claim_status', 'like', '%' . $search . '%')
                        ->orWhere('amount', 'like', '%' . $search . '%')
                        ->orWhereHas('senior', function ($query) use ($search) {
                            $query->where('name', 'like', '%' . $search . '%')
                                ->orWhere('osca_id', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('senior.barangay', function ($query) use ($search) {
                            $query->where('name', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('cycle', function ($query) use ($search) {
                            $query->where('cycle_name', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('counter', function ($query) use ($search) {
                            $query->where('counter_number', 'like', '%' . $search . '%')
                                ->orWhere('label', 'like', '%' . $search . '%');
                        });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('payout-transactions.index', compact('transactions', 'search'));
    }

    public function create()
    {
        $seniors   = Senior::where('status', 'active')->get();
        $cycles    = PayoutCycle::where('status', 'active')->get();
        $schedules = PayoutSchedule::with('barangay')->get();
        $counters  = Counter::where('is_active', 1)->get();
        return view('payout-transactions.create', compact('seniors', 'cycles', 'schedules', 'counters'));
    }

    public function store(StoreTransactionRequest $request)
    {

        try {
            DB::transaction(function () use ($request) {

                $senior = Senior::where('id', $request->senior_id)
                    ->lockForUpdate()
                    ->first();

                $alreadyClaimed = PayoutTransaction::where('senior_id', $senior->id)
                    ->where('cycle_id', $request->cycle_id)
                    ->where('claim_status', 'claimed')
                    ->exists();

                if ($alreadyClaimed) {
                    Log::warning('Duplicate claim attempt blocked', [
                        'senior_id'    => $senior->id,
                        'senior_name'  => $senior->name,
                        'cycle_id'     => $request->cycle_id,
                        'attempted_by' => Auth::user()->name,
                        'role'         => Auth::user()->role,
                        'ip'           => request()->ip(),
                        'timestamp'    => now()->toDateTimeString(),
                    ]);
                    throw new \Exception('This senior has already claimed payout for this cycle.');
                }

                $transaction = PayoutTransaction::create([
                    'cycle_id'     => $request->cycle_id,
                    'senior_id'    => $senior->id,
                    'schedule_id'  => $request->schedule_id,
                    'counter_id'   => $request->counter_id,
                    'processed_by' => Auth::id(),
                    'amount'       => $request->amount,
                    'claim_status' => $request->claim_status,
                    'claimed_at'   => $request->claim_status === 'claimed' ? now() : null,
                    'remarks'      => $request->remarks,
                ]);

                Log::info('Payout transaction recorded', [
                    'transaction_id' => $transaction->id,
                    'senior_id'      => $senior->id,
                    'senior_name'    => $senior->name,
                    'cycle_id'       => $request->cycle_id,
                    'amount'         => $request->amount,
                    'claim_status'   => $request->claim_status,
                    'processed_by'   => Auth::user()->name,
                    'role'           => Auth::user()->role,
                    'timestamp'      => now()->toDateTimeString(),
                ]);
            });

            $this->clearDashboardCache();

            return redirect()->route('payout-transactions.index')
                ->with('success', 'Transaction recorded successfully.');

        } catch (\Exception $e) {
            Log::error('Transaction store failed', [
                'error'      => $e->getMessage(),
                'senior_id'  => $request->senior_id,
                'cycle_id'   => $request->cycle_id,
                'user'       => Auth::user()->name,
                'timestamp'  => now()->toDateTimeString(),
            ]);
            return back()->withErrors(['senior_id' => $e->getMessage()]);
        }
    }

    public function show(PayoutTransaction $payoutTransaction)
    {
        $payoutTransaction->load([
            'senior.barangay', 'cycle', 'schedule',
            'counter', 'processor', 'submissions.requirement'
        ]);
        return view('payout-transactions.show', compact('payoutTransaction'));
    }

    public function edit(PayoutTransaction $payoutTransaction)
    {
        $this->denyStaffTransactionEditing();
        $seniors   = Senior::where('status', 'active')->get();
        $cycles    = PayoutCycle::where('status', 'active')->get();
        $schedules = PayoutSchedule::with('barangay')->get();
        $counters  = Counter::where('is_active', 1)->get();
        return view('payout-transactions.edit', compact(
            'payoutTransaction', 'seniors', 'cycles', 'schedules', 'counters'
        ));
    }

    public function update(Request $request, PayoutTransaction $payoutTransaction)
    {
        $this->denyStaffTransactionEditing();

        $request->validate([
            'cycle_id'     => 'required|exists:payout_cycles,id',
            'senior_id'    => 'required|exists:seniors,id',
            'schedule_id'  => 'nullable|exists:payout_schedules,id',
            'counter_id'   => 'nullable|exists:counters,id',
            'amount'       => 'required|numeric|min:0|max:99999.99',
            'claim_status' => 'required|in:claimed,unclaimed,cancelled',
            'remarks'      => 'nullable|string|max:500',
        ]);

        DB::transaction(function () use ($request, $payoutTransaction) {
            $claimedAt = $request->claim_status === 'claimed'
                ? ($payoutTransaction->claimed_at ?? now())
                : null;

            $payoutTransaction->update([
                'cycle_id'     => $request->cycle_id,
                'senior_id'    => $request->senior_id,
                'schedule_id'  => $request->schedule_id,
                'counter_id'   => $request->counter_id,
                'amount'       => $request->amount,
                'claim_status' => $request->claim_status,
                'claimed_at'   => $claimedAt,
                'remarks'      => $request->remarks,
            ]);

            Log::info('Payout transaction updated', [
                'transaction_id' => $payoutTransaction->id,
                'updated_by'     => Auth::user()->name,
                'claim_status'   => $request->claim_status,
                'amount'         => $request->amount,
                'timestamp'      => now()->toDateTimeString(),
            ]);
        });

        $this->clearDashboardCache();

        return redirect()->route('payout-transactions.index')
            ->with('success', 'Transaction updated.');
    }

    public function destroy(PayoutTransaction $payoutTransaction)
    {
        $this->denyStaffTransactionEditing();

        Log::info('Payout transaction deleted', [
            'transaction_id' => $payoutTransaction->id,
            'senior_id'      => $payoutTransaction->senior_id,
            'deleted_by'     => Auth::user()->name,
            'timestamp'      => now()->toDateTimeString(),
        ]);

        $payoutTransaction->delete();
        $this->clearDashboardCache();

        return redirect()->route('payout-transactions.index')
            ->with('success', 'Transaction deleted.');
    }

    public function updateStatus(Request $request, PayoutTransaction $payoutTransaction)
    {
        $this->denyStaffTransactionEditing();

        $request->validate([
            'claim_status' => 'required|in:claimed,unclaimed,cancelled',
        ]);

        try {
            DB::statement('BEGIN');

            $transaction = PayoutTransaction::where('id', $payoutTransaction->id)
                ->lockForUpdate()
                ->first();

            $transaction->update([
                'claim_status' => $request->claim_status,
                'claimed_at'   => $request->claim_status === 'claimed' ? now() : null,
            ]);

            DB::statement('COMMIT');

            Log::info('Claim status updated', [
                'transaction_id' => $transaction->id,
                'new_status'     => $request->claim_status,
                'updated_by'     => Auth::user()->name,
                'timestamp'      => now()->toDateTimeString(),
            ]);

            $this->clearDashboardCache();

            return redirect()->back()->with('success', 'Claim status updated.');

        } catch (\Exception $e) {
            DB::statement('ROLLBACK');

            Log::error('Claim status update failed', [
                'transaction_id' => $payoutTransaction->id,
                'error'          => $e->getMessage(),
                'user'           => Auth::user()->name,
                'timestamp'      => now()->toDateTimeString(),
            ]);

            return redirect()->back()->withErrors(['error' => 'Update failed: ' . $e->getMessage()]);
        }
    }

    private function clearDashboardCache(): void
    {
        $keys = [
            'kpi_claimed', 'kpi_unclaimed', 'kpi_cancelled',
            'kpi_amount', 'kpi_by_month', 'kpi_by_barangay',
        ];
        foreach ($keys as $key) {
            Cache::forget($key);
        }
    }

    private function denyStaffTransactionEditing(): void
    {
        if (Auth::user()?->role === 'staff') {
            abort(403, 'Staff accounts cannot edit payout transactions.');
        }
    }
}
