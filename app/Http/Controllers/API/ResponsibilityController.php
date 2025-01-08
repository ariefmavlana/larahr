<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Responsibility;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateResponsibilityRequest;

class ResponsibilityController extends Controller
{
    public function fetch(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $limit = $request->input('limit', 10);

        $responsibilityQuery = Responsibility::query();

        // Get Single Data
        if ($id) {
            $responsibility = $responsibilityQuery->find($id);

            if ($responsibility) {
                return ResponseFormatter::success($responsibility, 'Responsibility data retrieved successfully.');
            }
            return ResponseFormatter::error('Responsibility data not found.', 404);
        }

        // Get Multiple Data
        $responsibilities = $responsibilityQuery->where('role_id', $request->role_id);

        if ($name) {
            $responsibilities->where('name', 'like', '%' . $name . '%');
        }

        return ResponseFormatter::success(
            $responsibilities->paginate($limit),
            'Responsibility data retrieved successfully.'
        );
    }

    public function create(CreateResponsibilityRequest $request)
    {
        try {

            // Create Responsibility
            $responsibility = Responsibility::create([
                'name' => $request->name,
                'role_id' => $request->role_id,
            ]);

            if (!$responsibility) {
                throw new Exception('Responsibility not Created');
            }

            return ResponseFormatter::success($responsibility, 'Responsibility Created');
        } catch (Exception $error) {
            return ResponseFormatter::error($error->getMessage(), 500);
        }
    }

    public function destroy($id)
    {
        try {
            // Get Responsibility
            $responsibility = Responsibility::find($id);

            //todo Check if Responsibility is owned by User

            // Check if Responsibility Exist
            if (!$responsibility) {
                throw new Exception('Responsibility not found');
            }

            // Delete Responsibility
            $responsibility->delete();

            return ResponseFormatter::success('Responsibility Deleted');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }
}
