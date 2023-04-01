<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ChecklistItem;
use Carbon\Carbon;
use App\Checklist;

class ChecklistItemController extends Controller
{

    public function index($checklistId)
    {
        $checklistItems = ChecklistItem::where('checklist_id', $checklistId)->get();

        return response()->json([
            'success' => true,
            'data' => $checklistItems
        ]);
    }

    public function store(Request $request, $checklistId)
    {
        $checklist = Checklist::findOrFail($checklistId);

        if(!$checklist){
            return response()->json([
                'message' => 'Checklist not found'
            ], 404);
        }

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'item_name' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 400);
        }

        $checklistItem = new ChecklistItem();
        $checklistItem->checklist_id = $checklistId;
        $checklistItem->item_name = $request->item_name;
        $checklistItem->save();

        return response()->json([
            'success' => true,
            'message' => 'Checklist item created successfully',
            'data' => $checklistItem
        ]);
    }


    public function show($checklistId, $checklistItemId)
    {
        $checklistItem = ChecklistItem::where('checklist_id', $checklistId)
            ->where('id', $checklistItemId)
            ->first();
            
        if(!$checklistItem){
            return response()->json([
                'message' => 'Checklist item not found'
            ], 404);
        }
        
        return response()->json($checklistItem);
    }
    
    public function update(Request $request, $checklistId, $checklistItemId)
    {
        $checklistItem = ChecklistItem::where('checklist_id', $checklistId)
        ->where('id', $checklistItemId)
        ->first();

        if(!$checklistItem){
            return response()->json([
                'message' => 'Checklist item not found'
            ], 404);
        }

    
        $checklistItem->is_completed = 1;
        $checklistItem->completed_at = Carbon::now();
        $checklistItem->save();
    
        return response()->json($checklistItem);
    }

    public function destroy($checklistId, $checklistItemId)
    {
        $checklistItem = ChecklistItem::where('checklist_id', $checklistId)
            ->where('id', $checklistItemId)
            ->first();
        
        if(!$checklistItem){
            return response()->json([
                'message' => 'Checklist item not found'
            ], 404);
        }
        
        $checklistItem->delete();
        
        return response()->json([
            'message' => 'Checklist item deleted successfully'
        ]);
    }

    public function rename(Request $request, $checklistId, $checklistItemId)
    {
        $checklistItem = ChecklistItem::where('checklist_id', $checklistId)
        ->where('id', $checklistItemId)
        ->first();
        if(!$checklistItem){
            return response()->json([
                'message' => 'Checklist item not found'
            ], 404);
        }
    
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'item_name' => 'required|string|max:255'
        ]);
    
        if($validator->fails()){
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 400);
        }
    
        $checklistItem->item_name = $request->item_name;
        $checklistItem->save();
    
        return response()->json($checklistItem);
    }
}
