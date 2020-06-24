<?php

namespace App\Http\Controllers\Admin;

use App\Company;
use App\Employee;
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
            'companies' => Company::paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('admin.company.create');
    }

    public function store(CreateCompany $request): RedirectResponse
    {
        Company::create($request->inputWithWithUploadedLogo());

        flash('Company created')->success();

        return redirect()
            ->route('company.index')
            ->withInput();
    }

    public function show(Company $company): View
    {
        $employees = Employee::query()
            ->isEmployedBy($company)
            ->get()
            ->each(function (Employee $employee) use ($company) {
                $employee->setRelation('company', $company);
            });

        return view('admin.company.show', [
            'company' => $company,
            'employees' => $employees,
        ]);
    }

    public function edit(Company $company): View
    {
        return view('admin.company.edit', [
            'company' => $company,
        ]);
    }

    public function update(UpdateCompany $request, Company $company): RedirectResponse
    {
        $company->update($request->inputWithWithUploadedLogo());

        flash('Company updated')->success();

        return redirect()
            ->route('company.index')
            ->withInput();
    }

    public function destroy(Company $company): RedirectResponse
    {
        $company->delete();

        flash('Company deleted')->success();

        return redirect()->route('company.index');
    }
}
