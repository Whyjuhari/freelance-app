<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $sort = $request->input('sort', 'latest');

        $clients = Clients::where('user_id', Auth::id())
            ->withCount('projects')
            ->with('projects.finances')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');
                $query->where(function ($query) use ($search) {
                    $query->where('company_name', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('alamat_email', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), fn($query) => $query->where('status', $request->input('status')))
            ->when($sort === 'name_asc', fn($query) => $query->orderBy('company_name')->orderBy('name'))
            ->when($sort === 'name_desc', fn($query) => $query->orderByDesc('company_name')->orderByDesc('name'))
            ->when(!in_array($sort, ['name_asc', 'name_desc'], true), fn($query) => $query->latest())
            ->paginate(9)
            ->withQueryString();

        $clients->getCollection()->transform(function ($client) {
            $client->revenue = $client->projects
                ->flatMap->finances
                ->where('type', 'income')
                ->sum('amount');

            return $client;
        });

        $totalClients = Clients::where('user_id', Auth::id())->count();

        $activeClients = Clients::where('user_id', Auth::id())
            ->where('status', 'active')
            ->count();

        $totalRevenue = auth()->user()
            ->finances()
            ->where('type', 'income')
            ->sum('amount');


        $newThisMonth = Clients::where('user_id', auth()->id())
            ->whereBetween('created_at', [
                now()->startOfMonth(),
                now()->endOfMonth(),
            ])
            ->count();


        return view('clients.index', compact('clients', 'totalClients', 'activeClients', 'totalRevenue', 'newThisMonth'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'alamat_email' => 'nullable|string|lowercase|email|max:255',
            'phone' => 'required|numeric',
            'status' => 'required|in:active,inactive',
            'notes' => 'nullable|string|max:1000',
        ]);

        $validated['user_id'] = auth()->id();
        Clients::create($validated);
        return redirect()->route('client.index')->with('success', 'Client Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = Clients::where('user_id', Auth::id())
            ->withCount('projects')
            ->findOrFail($id);

        return redirect()
            ->route('client.index')
            ->with('success', "{$client->company_name} memiliki {$client->projects_count} proyek.");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $client = Clients::findOrFail($id);
        abort_if($client->user_id !== Auth::id(), 403);

        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'alamat_email' => 'nullable|string|lowercase|email|max:255',
            'phone' => 'required|numeric',
            'status' => 'required|in:active,inactive',
            'notes' => 'nullable|string|max:1000',
        ]);
        $client->update($validated);
        return redirect()->route('client.index')->with('success', 'Client Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Clients $client)
    {
        abort_if($client->user_id !== Auth::id(), 403);

        $client->delete();

        return redirect()
            ->route('client.index')
            ->with('success', 'Client Delete Successfully!');
    }
}
