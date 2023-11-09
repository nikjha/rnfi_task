<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        // Retrieve data from session
        $users = Session::get('userData', []);
        if (empty($users)) {
            $users = User::all(); // Retrieve all users from the database
        }
        // Pass data to the view
        return view('index', compact('users'));
    }

    public function showForm()
    {
        return view('add_form');
    }

    public function addData(Request $request)
    {
        $data = $request->except('image'); // Exclude the 'image' field from the request
        $data['id'] = uniqid(); // Generate unique ID for the record

        // Handle file upload separately
        if ($request->hasFile('image')) {
            // $imagePath = $request->file('image')->store('images'); // Store the image and get its path
            $imagePath = $request->file('image')->store('images', 'public'); // Store the image in the public disk
            $data['image'] = $imagePath;
        }

        // Add data to session array
        $userData = Session::get('userData', []);
        $userData[] = $data;
        Session::put('userData', $userData);

        return redirect('/index')->with('success', 'Data added successfully!');
    }



    public function editForm($id)
    {
        // Retrieve data from session based on $id
        $userData = Session::get('userData', []);
        $user = collect($userData)->firstWhere('id', $id);
        if(!$user){
            $user = User::find($id);

        }

        return view('edit_form', compact('user'));
    }

    public function updateData(Request $request, $id)
    {
        // Update data in session based on $id
        $userData = Session::get('userData', []);
        $userIndex = collect($userData)->search(function ($user) use ($id) {
            return $user['id'] == $id;
        });

        if ($userIndex !== false) {
            $data = $request->except('image');
            
            // Handle file upload separately
            if ($request->hasFile('image')) {
                // $imagePath = $request->file('image')->store('images');
                $imagePath = $request->file('image')->store('images', 'public'); // Store the image in the public disk
                $data['image'] = $imagePath;
            }

            $userData[$userIndex] = $data;
            Session::put('userData', $userData);

            return redirect('/edit/'.$id)->with('success', 'Data updated successfully!');
        }

        return redirect('/index')->with('error', 'Record not found!');
    }


    public function deleteData($id)
    {
        // Delete data from session based on $id
        $userData = Session::get('userData', []);
        $userData = collect($userData)->reject(function ($user) use ($id) {
            return $user['id'] == $id;
        })->values()->all();
        
        if(!$userData){
                        // Delete user from the database
            User::where('id', $id)->delete();
        }
        else{
            Session::put('userData', $userData);
        }
        

        return redirect('/index')->with('success', 'Data deleted successfully!');
    }

    public function finalSubmit()
    {
        // Get data from session
        $userData = Session::get('userData', []);

        // Save data to the database
        foreach ($userData as $user) {
            User::create($user);
        }

        // Destroy the session after saving data to the database
        Session::forget('userData');

        return redirect('/index')->with('success', 'Data submitted and saved to the database successfully!');
    }

}

