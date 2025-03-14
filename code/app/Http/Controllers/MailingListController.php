<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use App\Models\LabelMailingListsModel;


/**
 * 
 */
class MailingListController 
    extends Controller
{
    /**
     * 
     */
    public function select( $request_id )
    {
        $model = LabelMailingListsModel::find($request_id);

        if( is_null( $model ) )
        {
            return response()->json('Post does not exist.', 200);
        }
        
        return response()->json($model, 200);
    }


    /**
     * 
     */
    public function select_by_name( string $request ): ?LabelMailingListsModel
    {
        $model = LabelMailingListsModel::where( 'content', $request )->first();

        if( is_null( $model ) )
        {
            return $model;
        }
        
        return $model;
    }


    /**
     * 
     */
    public function page( Request $request )
    {
        // self::logClientIP( $request );
        
        return response()->json($request, 200);
    }


    /**
     * 
     */
    public function create( Request $request )
    {
        // self::logClientIP( $request );

        $mailRequest = $request->all();

        $validator = Validator::make( $mailRequest, [
            'mail' => 'required|email'
            ] 
        );

        if( $validator->fails() )
        {
            return $this->sendError( 'Error validation', $validator->errors() );       
        }

        $model['content'] = $request->input('mail');
        $creation = LabelMailingListsModel::create($model);

        return response()->json($creation, 200);
    }


    /**
     * 
     */
    public function update( Request $request )
    {
        // self::logClientIP( $request );

        $model = LabelMailingListsModel::find( $request->input( 'id' ) );
        
        $model->content = $request->input('mail');
        $model->save();
        
        return response()->json('success', 200);
    }


    /**
     * 
     */
    public function delete( request $request )
    {
        // self::logClientIP( $request );

        $mailRequest = $request->all();

        $validator = Validator::make( $mailRequest, [
            'mail' => 'email',
            'id'=>'integer'
            ] 
        );

        if( $validator->fails() )
        {
            return $this->sendError( 'Error validation', $validator->errors() );       
        }

        LabelMailingListsModel::destroy( $request->input( 'id' ) );
        
        return response()->json('success', 200);
    }

}