<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function index(Request $request){
        if(!$request->website) return response()->json(['message' => 'Website not found'], 400);
        return response()->json($request->website->contacts);
    }
    public function save(Request $request){
        $contacts = collect();
        $old_contacts = Contact::whereHas('website', function ($q)use($request){
            $q->where('user_id', $request->user('api')->id);
        })->get();
        foreach ($request->contacts as $contact){
            $validator = Validator::make($contact, [
                'name' => 'required',
                'email' => 'required|email',
                'website_id' => 'required|exists:websites,id'
            ]);
            if($validator->fails()) return response()->json($validator->errors(), 400);
            if(array_key_exists('id', $contact)){
                $data = Contact::find($contact['id']);
                if($data){
                    $data->update($contact);
                }
            }else{
                $data= Contact::create($contact);
            }
            $contacts->push($data);
        }
        foreach ($old_contacts as $c){
            if(!$contacts->where('id', $c->id)->first()) $c->delete();
        }
        return response()->json($contacts);
    }
}
