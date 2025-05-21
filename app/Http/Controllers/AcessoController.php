<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class AcessoController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('page_views')->orderByDesc('created_at');

        if ($request->filled('data')) {
            $query->whereDate('created_at', $request->data);
        }

        if ($request->filled('ip')) {
            $query->where('ip', 'like', '%' . $request->ip . '%');
        }

        if ($request->filled('url')) {
            $query->where('url', 'like', '%' . $request->url . '%');
        }

        $acessos = $query->paginate(15);

        return view('admin.acessos.index', compact('acessos'));
    }

    public function export()
    {
        $acessos = DB::table('page_views')->orderBy('created_at', 'desc')->get();

        $csv = "Data,IP,URL,Usuário\n";

        foreach ($acessos as $a) {
            $csv .= $a->created_at . "," . $a->ip . "," . $a->url . "," . ($a->user_id ?? 'Visitante') . "\n";
        }

        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="acessos.csv"',
        ]);
    }

    public function dashboard()
    {
    $daily = DB::table('page_views')
        ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
        ->groupByRaw('DATE(created_at)')
        ->orderBy('date', 'desc')
        ->limit(15)
        ->get();

    $totalAcessos = DB::table('page_views')->count();
    $totalUrls = DB::table('page_views')->distinct()->count('url');
    $totalUsers = DB::table('page_views')->distinct()->count('ip');

    return view('admin.acessos.dashboard', [
        'labels' => $daily->pluck('date'),
        'data' => $daily->pluck('total'),
        'totalAcessos' => $totalAcessos,
        'totalUrls' => $totalUrls,
        'totalUsers' => $totalUsers,
    ]);
    }
}