<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $client = Client::count();
        if($client == 0){
            return response()->json(["message" => "This field is empty"], 404);
        }
        return response()->json(Client::get(), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'firstname' => 'required|min:3',
            'lastname' => 'required|min:3',
            'contact_number' => 'required|max:11|unique:client',
            'address' => 'required|min:3',
            'username' => 'required|min:3|unique:client',
            'password' => 'required|min:8'
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }
        $this->register($request);
        return response()->json(["message"=>"Added Successfully!"], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Client::find($id);
        if(is_null($client)){
            return response()->json(["message" => "Id is not Found!"], 404);
        }
        return response()->json($client, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $client = Client::find($id);
        if(is_null($client)){
            return response()->json(["message" => "Id is not Found!"], 404);
        }
        $client->update($request->all());
        return response()->json($client, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Client::find($id);
        if(is_null($client)){
            return response()->json(["message" => "Id is not Found!"], 404);
        }
        $client->delete();
        return response()->json(["message" => "Successfully deleted!"], 204);
    }

    //Log-Reg

    public function login(Request $request)
    {
        
    $client = Client::where('email_address', $request->email_address)->first();
    if (!$client || !Hash::check($request->password, $client->password)) {
    return response([
    'message' => ['This credential does not match in our records!']
    ], 404);
    }

    $token = $client->createToken('my_app_token')->plainTextToken;

    $response = [
    'user' => $client,
    'token' => $token
    ];
    return response($response, 201);
    }

    public function register(Request $request)
    {
        $rules = [
            'firstname' => 'required|min:3',
            'lastname' => 'required|min:3',
            'address' => 'required|min:3',
            'contact_number' => 'required|min:3|max:11',
            'email_address' => 'required|min:3|unique:client',
            'password' => 'required|min:8'
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }

        $client = new Client();
        $client->firstname = $request->firstname;
        $client->lastname = $request->lastname;
        $client->address = $request->address;
        $client->contact_number = $request->contact_number;
        $client->email_address = $request->email_address;
        $client->password = Hash::make($request->password);
        $client->save();
        return response()->json($client, 201);
    }

}