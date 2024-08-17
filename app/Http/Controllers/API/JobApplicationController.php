<?php

namespace App\Http\Controllers\API;

use App\Models\Work;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Resources\WorkResource;
use App\Http\Resources\JobApplicationResource;
use Exception;

class JobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function apply(Request $request, $workId)
    {

        try{

            $user = $request->user();
            $work = Work::findOrFail($workId);

            if (!$work) {
                return response()->json(['error' => 'Work Detials not found'], 404);
            }

            $user->jobs()->attach($workId, ['status' => 'applied']);

            return response()->json([
                'status' => true, 
                'message' => 'Application submitted',
                'data' => new UserResource($user),
                'appliedWork' => new WorkResource($work),
            ]);

        } catch(Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
        
    }

    public function applications($workId)
    {
   
        try{
            $work = Work::with('appliedUser')->findOrFail($workId);
            $workResource = new JobApplicationResource($work);
    
            return response()->json([
                'status' => true,
                'message' => 'Applications retrieved',
                'data' => $workResource,
            ], 200);
        }catch(Exception $e){
            
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
        
       
    }
}
