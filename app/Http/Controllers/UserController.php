<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = Session::get('userData', []);
        if (empty($users)) {
            $users = User::all(); 
        }
        return view('index', compact('users'));
    }

    public function showForm()
    {
        return view('add_form');
    }

    public function addData(Request $request)
    {
        $data = $request->except('image'); 
        $data['id'] = uniqid(); // Generating unique ID for the record

        // Handling file upload separately
        if ($request->hasFile('image')) {
        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('images'), $imageName);
        $data['image'] = $imageName;

        }

        // Adding data to session array
        $userData = Session::get('userData', []);
        $userData[] = $data;
        Session::put('userData', $userData);

        return redirect('/index')->with('success', 'Data added successfully!');
    }



    public function editForm($id)
    {
        $userData = Session::get('userData', []);
        $user = collect($userData)->firstWhere('id', $id);
        if(!$user){
            $user = User::find($id);

        }

        return view('edit_form', compact('user'));
    }

    public function updateData(Request $request, $id)
    {
        $userData = Session::get('userData', []);
        $userIndex = collect($userData)->search(function ($user) use ($id) {
            return $user['id'] == $id;
        });
        $request->validate([
            'image' => 'required|image|mimes:png,jpg,jpeg|max:2048'
        ]);

        if ($userIndex !== false) {
            $data = $request->except('image');
            
            if ($request->hasFile('image')) {
                $imageName = time().'.'.$request->image->extension();
                $request->image->move(public_path('images'), $imageName);
                $data['image'] = $imageName;
            }

            $userData[$userIndex] = $data;
            Session::put('userData', $userData);

            return redirect('/edit/'.$id)->with('success', 'Data updated successfully!');
        }

        return redirect('/index')->with('error', 'Record not found!');
    }


    public function deleteData($id)
    {
        $userData = Session::get('userData', []);
        $userData = collect($userData)->reject(function ($user) use ($id) {
            return $user['id'] == $id;
        })->values()->all();
        
        if(!$userData){
                        
            User::where('id', $id)->delete();
        }
        else{
            Session::put('userData', $userData);
        }
        

        return redirect('/index')->with('success', 'Data deleted successfully!');
    }

    public function finalSubmit()
    {
        // Geting data from session
        $userData = Session::get('userData', []);

        // Saving data to the database
        foreach ($userData as $user) {
            User::create($user);
        }

        // Destroy the session after saving data to the database
        Session::forget('userData');

        return redirect('/index')->with('success', 'Data submitted and saved to the database successfully!');
    }

}

