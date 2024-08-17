<?php

namespace App\Http\Controllers\API;

use App\Models\Work;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\WorkResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class WorkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        try {

            $workDetails = Work::with('user')->get();

            return response()->json([
                'status' => true,
                'message' => 'Work Details Fetched Successfully',
                'data' => WorkResource::collection($workDetails),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve Work Details',
                'error' => $e->getMessage(),
            ], 500);
        }
      
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        if (!Auth::check()) {
            return response()->json(['status' => false,'message' => 'Unauthorized'], 401);
        }
        
        $work = Work::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'company' => $request->input('company'),
            'location' => $request->input('location'),
            'salary' => $request->input('salary'),
            'user_id' => Auth::id(),
        ]);

        $workDetails = Work::with('user')->find($work->id);

        return response()->json([
            'status' => true,
            'message' => 'Work created successfully.',
            'data' => new WorkResource($workDetails),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $workDetails = Work::with('user')->findOrFail($id);
            
            return response()->json([
                'status' => true,
                'message' => 'Work record retrieved successfully',
                'data' => new WorkResource($workDetails),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve data results',
                'error' => $e->getMessage(),
            ], 500);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
   
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        try {

            $work = Work::with('user')->findOrFail($id);
        
            $work->update($request->only([
                'title',
                'description',
                'company',
                'location',
                'salary'
            ]));

            return response()->json([
                'status' => true,
                'message' => 'Work record updated successfully',
                'data' => new WorkResource($work),
            ], 200);

        } catch (Throwable $e) {
            return response()->json([
                'message' => 'Work record not found '.$e,
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

            $work = Work::findOrFail($id);
            $work->delete();
    
            return response()->json([
                'status' => true,
                'message' => 'Work record deleted successfully',
            ], 200);
    
        } catch (Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => 'Work record not found. '. $e,
            ], 404);
        }
    }

    public function search(Request $request)
    {

        $title = $request->query('title');
        $location = $request->query('location');

        $search = Work::query();

        if (!empty($title)) {
            $search = $search->where('title', 'like', '%' . $title. '%');
        }
        if (!empty($location)) {
            $search =  $search->where('location', 'like', '%' . $location . '%');
        }

        try {

            $works = $search->get();

            return response()->json([
                'status' => true,
                'message' => 'Search results',
                'data' => WorkResource::collection($works),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve search results',
                'error' => $e->getMessage(),
            ], 500);
        }
        
    }

}
