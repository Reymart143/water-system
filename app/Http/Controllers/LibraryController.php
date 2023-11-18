<?php

namespace App\Http\Controllers;

use App\Models\Library;
use Illuminate\Http\Request;
use DB;
use dataTables;
class LibraryController extends Controller
{
  
    public function store(Request $request)
    {

        $validationRules = [
            'category' => 'required',
        ];
    
        if ($request->input('category') === 'Rate Case' || $request->input('category') === 'Classification' || $request->input('category') === 'Cluster' || $request->input('category') === 'Trade' || $request->input('category') === 'Collector' || $request->input('category') === 'Meter Brand'  || $request->input('category') === 'Meter' || $request->input('category') === 'Reader' ) {
            $validationRules['categoryaddedName'] = 'required';
        } else {
            
        }
    
        $validatedData = $request->validate($validationRules);
    
      
        $library = Library::create($validatedData);
    
      
        return response()->json([
            'message' => 'Library entry added successfully.',
            'library' => $library,
        ]);
    }
    

  
    public function show(Request $request)
    {
        
        if ($request->ajax()) {
            $addlibrary = DB::table('libraries')
                ->orderBy('libraries.created_at', 'asc')
                ->select('id', 'category', 'categoryaddedName')
                ->get();
    
            $formattedAddLibrary = $addlibrary->map(function ($item) {
                if ($item->category === 'Meter') {
                   
                    $item->categoryaddedName = str_replace('-', ' ', $item->categoryaddedName);
                }
                return $item;
            });
    
            return datatables()->of($formattedAddLibrary)->addIndexColumn()
                ->addColumn('action', function ($addlibrary) {
                    $button = '
                        <input type="hidden" id="account_' . $addlibrary->id . '" value="' . $addlibrary->category . '"/>
                       
                        <button type="button" name="edit" onclick="editmodalcategory(' . $addlibrary->id . ')" class="action-button accept btn btn-success btn-sm" style="margin-left:7px;padding-top: 2mm;padding-bottom: 2mm;padding-left: 3mm; padding-right: 3mm;font-size: 10px;"><i class="fa fa-edit"></i>  <span class="action-text" style="font-size:12px">Edit</span></button>
                        <button type="button" name="softDelete" onclick="categorysuperadmin(' . $addlibrary->id . ')" class="action-button softDelete btn btn-danger btn-sm" style="margin-left:7px;padding-top: 2mm;padding-bottom: 2mm; padding-left: 3mm; padding-right: 3mm;font-size: 10px;"><i class="fa fa-trash-o"></i>  <span class="action-text" style="font-size:8px">Delete</span></button>
                        ';
                    return $button;
                })
                ->make(true);
        }
        return view('library.addlibrary');
    }
    public function edit($id)
        {
           
            if(request()->ajax())
            {
                $data = Library::findOrFail($id);
                return response()->json(['result' => $data]);
            }
        }
        public function update(Request $request)
        {
            $category = $request->category;
            $categoryaddedName = $request->categoryaddedName;

            if ($category === 'Meter') {

                $meterData = explode('  ', $categoryaddedName);

                if (count($meterData) === 2) {
                   
                    $meterBrand = $meterData[0];
                    $meterSerialNum = $meterData[1];

                    DB::table('libraries')->where('id', $request->id)->update([
                        'category' => $category,
                        'categoryaddedName' => $categoryaddedName,
                       
                    ]);
                }
            } else {
                
                DB::table('libraries')->where('id', $request->id)->update([
                    'category' => $category,
                    'categoryaddedName' => $categoryaddedName,
                ]);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Success Update Info!!'
            ]);
        }
        public function delete($id)
        {
            return view('confirm-delete', ['id' => $id]);
        }
        public function categoryDelete($id){
            try {
                $category = Library::findOrFail($id);
                $category->delete();
                return response()->json(['message' => 'Customer deleted successfully']);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return response()->json(['error' => 'User not found'], 404);
            } catch (\Exception $e) {
                return response()->json(['error' => 'An error occurred while deleting the user'], 500);
            }
        }
        public function no_reload()
        {
            $brands = DB::table('libraries')
            ->where('category', 'Meter Brand')
            ->pluck('categoryaddedName');
    
        return response()->json($brands);
        }
        public function view_norefresh()
        {
           
            $brands = DB::table('libraries')
            ->where('category', 'Meter Brand')
            ->pluck('categoryaddedName');
    
        return response()->json($brands);
        }
        
}
