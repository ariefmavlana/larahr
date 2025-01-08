<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Team;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTeamRequest;
use App\Http\Requests\UpdateTeamRequest;

class TeamController extends Controller
{
    public function fetch(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $limit = $request->input('limit', 10);

        $teamQuery = Team::query();

        // Get Single Data
        if ($id) {
            $team = $teamQuery->find($id);

            if ($team) {
                return ResponseFormatter::success($team, 'Team data retrieved successfully.');
            }
            return ResponseFormatter::error('Team data not found.', 404);
        }

        // Get Multiple Data
        $teams = $teamQuery->where('company_id', $request->company_id);

        if ($name) {
            $teams->where('name', 'like', '%' . $name . '%');
        }

        return ResponseFormatter::success(
            $teams->paginate($limit),
            'Team data retrieved successfully.'
        );
    }

    public function create(CreateTeamRequest $request)
    {
        try {
            // Upload Icon
            if ($request->hasFile('icon')) {
                $path = $request->file('icon')->store('public/icons');
            }
            // Create Team
            $team = Team::create([
                'name' => $request->name,
                'icon' => $path,
                'company_id' => $request->company_id,
            ]);

            if (!$team) {
                throw new Exception('Team not Created');
            }

            return ResponseFormatter::success($team, 'Team Created');
        } catch (Exception $error) {
            return ResponseFormatter::error($error->getMessage(), 500);
        }
    }

    public function update(UpdateTeamRequest $request, $id)
    {
        try {
            //Get Team
            $team = Team::find($id);

            //Check if Team Exist
            if (!$team) {
                throw new Exception('Team not found');
            }

            //Upload Icon
            if ($request->hasFile('icon')) {
                $path = $request->file('icon')->store('public/icons');
            }

            //Update Team
            $team->update([
                'name' => $request->name,
                'icon' => $path,
                'company_id' => $request->company_id,
            ]);

            return ResponseFormatter::success($team, 'Team Updated');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }

    public function destroy($id)
    {
        try {
            // Get Team
            $team = Team::find($id);

            //todo Check if Team is owned by User

            // Check if Team Exist
            if (!$team) {
                throw new Exception('Team not found');
            }

            // Delete Team
            $team->delete();

            return ResponseFormatter::success('Team Deleted');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }
}
