<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Store\Team;
use Illuminate\Database\Eloquent\Builder;

class TeamController extends Controller
{
    /**
     * Display the specified team.
     *
     * @param int $id ID of the team
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, int $id)
    {
        $validated = $request->validate([
            'with' => 'string|nullable'
        ]);

        $withRelations = [];

        if (isset($validated['with'])) {
            $withParams = explode(',', $validated['with']);
            if (in_array('products', $withParams)){
                array_push($withRelations, 'products');
            }
        }

        return Team::with($withRelations)->findorfail($id);
    }
    /**
     * Display the products of the team.
     *
     * @param int $id ID of the team
     * @return \Illuminate\Http\Response
     */
    public function products(int $id) {
        return Team::findorfail($id)->products()->get();
    }
}
