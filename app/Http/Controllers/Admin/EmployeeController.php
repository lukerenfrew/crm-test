<?php

namespace App\Http\Controllers\Admin;

use App\Company;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEmployee;
use App\Http\Requests\UpdateEmployee;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function index(): View
    {
        return view('admin.employee.index', [
            'employees' => Employee::with('company')->paginate(10)
        ]);
    }

    public function create(): View
    {
        return view('admin.employee.create', [
            'companies' => Company::all()
        ]);
    }

    public function store(CreateEmployee $request): RedirectResponse
    {
        Employee::make($request->only('firstname', 'surname', 'email', 'phone'))
            ->employedBy(Company::findOrFail($request->get('company')))
            ->save();

        flash('Employee created')->success();

        return redirect()
            ->route('employee.index')
            ->withInput();
    }

    public function show(Employee $employee): View
    {
        return view('admin.employee.show', [
            'employee' => $employee
        ]);
    }

    public function edit(Employee $employee): View
    {
        return view('admin.employee.edit', [
            'employee' => $employee,
            'companies' => Company::all()
        ]);
    }

    public function update(UpdateEmployee $request, Employee $employee): RedirectResponse
    {
        $employee
            ->employedBy(Company::findOrFail($request->get('company')))
            ->update($request->only('firstname', 'surname', 'email', 'phone'));

        flash('Employee updated')->success();

        return redirect()
            ->route('employee.index')
            ->withInput();
    }

    public function destroy(Employee $employee): RedirectResponse
    {
        $employee->delete();

        flash('Employee deleted')->success();

        return redirect()->route('employee.index');
    }
}
