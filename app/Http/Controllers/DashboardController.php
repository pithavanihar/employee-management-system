<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        // 1. Department highest salary
        $highestSalaries = DB::table('employees as e')
            ->join('departments as d', 'e.department_id', '=', 'd.id')
            ->select('d.id as dept_id', 'd.name as department', 'e.name as employee', 'e.salary')
            ->whereRaw('e.salary = (
                SELECT MAX(e2.salary)
                FROM employees e2
                WHERE e2.department_id = e.department_id
            )')
            ->groupBy('d.id', 'd.name', 'e.name', 'e.salary')
            ->get();

        // 2. Salary wise employee count
        $salaryRanges = [
            '0 - 50000' => [0, 50000],
            '50001 - 100000' => [50001, 100000],
            '100001+' => [100001, PHP_INT_MAX],
        ];

        $salaryStats = [];
        foreach ($salaryRanges as $label => [$min, $max]) {
            $salaryStats[$label] = DB::table('employees')
                ->whereBetween('salary', [$min, $max])
                ->count();
        }

        // 3. Young employee of department
        $youngestEmployees = DB::table('employees as e')
        ->join('departments as d', 'e.department_id', '=', 'd.id')
        ->select(
            'd.id as dept_id',
            'd.name as department',
            'e.name as employee',
            'e.dob',
            DB::raw('
            CONCAT(
                TIMESTAMPDIFF(YEAR, e.dob, CURDATE()), " years ",
                TIMESTAMPDIFF(MONTH, e.dob, CURDATE()) % 12, " months"
            ) as age
        ')
        )
        ->whereRaw('e.dob = (
            SELECT MAX(e2.dob)
            FROM employees e2
            WHERE e2.department_id = e.department_id
        )')
        ->groupBy('d.id', 'd.name', 'e.name', 'e.dob')
        ->get();
    

        return view('dashboard', compact('highestSalaries', 'salaryStats', 'youngestEmployees'));
    }
}
