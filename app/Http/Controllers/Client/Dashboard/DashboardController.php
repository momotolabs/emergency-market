<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Concerns\ContractStatus;
use App\Models\InsuredContract;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function contractsOpen()
    {
        return Inertia::render('Dashboard/Contracts/Open', [
            'contracts' => InsuredContract::query()
                ->select(['insured_contracts.*'])
                ->with(['insured'])
                ->join('contracts', 'insured_contracts.contract_id', '=', 'contracts.id')
                ->where('contracts.company_id', '=', Auth::user()->company->id)
                ->where('insured_contracts.status', '=', ContractStatus::OPEN->value)
                ->latest('insured_contracts.created_at')->paginate()->withQueryString(),
        ]);
    }

    public function contractsViewed()
    {
        return Inertia::render('Dashboard/Contracts/Viewed', [
            'contracts' => InsuredContract::query()
                ->select(['insured_contracts.*'])
                ->with(['insured'])
                ->join('contracts', 'insured_contracts.contract_id', '=', 'contracts.id')
                ->where('contracts.company_id', '=', Auth::user()->company->id)
                ->where('insured_contracts.status', '=', ContractStatus::VIEWED->value)
                ->latest('insured_contracts.created_at')->paginate()->withQueryString(),
        ]);
    }

    public function contractsClosed()
    {
        return Inertia::render('Dashboard/Contracts/Closed', [
            'contracts' => InsuredContract::query()
                ->select(['insured_contracts.*'])
                ->with(['insured', 'invoice'])
                ->join('contracts', 'insured_contracts.contract_id', '=', 'contracts.id')
                ->where('contracts.company_id', '=', Auth::user()->company->id)
                ->where('insured_contracts.status', '=', ContractStatus::CLOSED->value)
                ->latest('insured_contracts.created_at')->paginate()->withQueryString(),
        ]);
    }

    public function profile()
    {
        return Inertia::render('Dashboard/Profile/Index');
    }

    public function builder()
    {
        return Inertia::render('Dashboard/Builder/Index');
    }

    public function showContract(InsuredContract $insuredcontract)
    {
        return Inertia::render('Dashboard/Contracts/Show/Index', [
            'contract' => $insuredcontract->load('insuredSignature'),
            'insured' => $insuredcontract->insured,
            'company' => Auth::user()->company,
            'provider' => Auth::user()->providerProfile,
            'resources' => Auth::user()->company->pricingResource->load(['resource']),
        ]);
    }
}
