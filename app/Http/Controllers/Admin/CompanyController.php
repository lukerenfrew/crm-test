<?php

namespace App\Http\Controllers\Admin;

use App\Company;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCompany;
use App\Http\Requests\UpdateCompany;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CompanyController extends Controller
{
    public function index(): View
    {
        return view('admin.company.index', [
            'companies' => Company::all()
        ]);
    }

    public function create(): View
    {

    }

    public function store(CreateCompany $request)
    {
        Company::create($request->validated());

        session()->flash('success', 'Company created');

        return redirect()->route('company.index');
    }

    public function show(Company $company): View
    {
        return view('admin.company.index', [
            'company' => $company
        ]);
    }

    public function edit(Company $company): View
    {
        return view('admin.company.edit', [
            'company' => $company
        ]);
    }

    public function update(UpdateCompany $request, Company $company): RedirectResponse
    {
        $company->update($request->validated());

        session()->flash('success', 'Company update');

        return redirect()->route('company.index');
    }

    public function destroy(Company $company): RedirectResponse
    {
        $company->delete();

        session()->flash('success', 'Company update');

        return redirect()->route('company.index');
    }
}
