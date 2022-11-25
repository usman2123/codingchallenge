<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Request as RequestModel;
use Auth;

class NetworkConnectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('network-connections');
    }

    public function getSuggestions()
    {
        $requestedIds = RequestModel::where('from_user_id', '=', Auth::user()->id)->get()->pluck(['to_user_id'])->toArray();
        $receivedIds = RequestModel::where('to_user_id', '=', Auth::user()->id)->get()->pluck(['from_user_id'])->toArray();
        
        $suggestedUsers = User::where('id','!=',Auth::user()->id)
            ->whereNotIn('id', array_merge($requestedIds,$receivedIds))
            ->paginate(10);
                                
        return \Response::json($suggestedUsers);
    }

    public function sendRequest(Request $request)
    {
        $suggestionId = $request->get('suggestionId');
        
        $data = RequestModel::create([
            'from_user_id' => Auth::user()->id, 
            'to_user_id' => $suggestionId
        ]);
                                
        return \Response::json($data);
    }

    public function getRequests($mode)
    {
        $requestedData = RequestModel::when($mode == 'sent', function ($query) {
                            $query->where('from_user_id', '=', Auth::user()->id)
                                    ->join('users', 'users.id' ,'=', 'requests.to_user_id');
                        }, function ($query) {
                            $query->where('to_user_id', '=', Auth::user()->id)
                                    ->join('users', 'users.id' ,'=', 'requests.from_user_id');
                        })
                        ->where('requests.status','!=', 'accepted')
                        ->select('users.*','requests.id as request_id' )
                        ->paginate(10);

        return \Response::json($requestedData);
    }
    
    public function deleteRequest(Request $request)
    {
        $requestId = $request->get('requestId');
        $data = RequestModel::where('id',$requestId)->delete();
                                
        return \Response::json($data);
    }

    public function acceptRequest(Request $request)
    {
        $requestId = $request->get('requestId');
        $data = RequestModel::where('id',$requestId)->update(['status' => 'accepted']);
                                
        return \Response::json($data);
    }
    
    public function getConnections()
    {
        $requestedIds = RequestModel::where('from_user_id', '=', Auth::user()->id)->where('status','=', 'accepted')->get()->pluck(['id'])->toArray();


        $requestedIds = RequestModel::where('from_user_id', '=', Auth::user()->id)->where('status','=', 'accepted')->get()->pluck(['id'])->toArray();
        $receivedIds = RequestModel::where('to_user_id', '=', Auth::user()->id)->where('status','=', 'accepted')->get()->pluck(['id'])->toArray();

        $acceptedData = RequestModel::whereIn('requests.id', array_merge($requestedIds,$receivedIds))
            ->join('users', 'users.id' ,'=', 'requests.from_user_id')
            ->where('users.id','!=',Auth::user()->id)
            ->select('users.*','requests.id as request_id' )
            ->paginate(10);

        $accepted = RequestModel::whereIn('requests.id', array_merge($requestedIds,$receivedIds))
            ->join('users', 'users.id' ,'=', 'requests.from_user_id')
            ->where('users.id','!=',Auth::user()->id)
            ->select('users.*','requests.id as request_id' )
            ->get();

        $firstFrnds = $accepted->pluck('id')->toArray();

        foreach ($acceptedData->items() as $value) {
            $requestedIds = RequestModel::where('to_user_id', '=', $value->id)->where('status','=', 'accepted')->get()->pluck(['from_user_id'])->toArray();
            $receivedIds = RequestModel::where('from_user_id', '=', $value->id)->where('status','=', 'accepted')->get()->pluck(['to_user_id'])->toArray();
            $secondFrnds = array_merge($requestedIds,$receivedIds);

            $commonFrndsArr = array_intersect($firstFrnds, $secondFrnds);

            $commonFrnds = User::whereIn('id', $commonFrndsArr)->get();

            $value->commonFrnds = $commonFrnds;
            $value->commonFriendsCount = count($commonFrndsArr);
        }

        return \Response::json($acceptedData);
    }

    public function getCounts()
    {
        $requestedIds = RequestModel::where('from_user_id', '=', Auth::user()->id)->where('status','=', 'accepted')->get()->pluck(['id'])->toArray();
        $receivedIds = RequestModel::where('to_user_id', '=', Auth::user()->id)->where('status','=', 'accepted')->get()->pluck(['id'])->toArray();

        $acceptedDataCount = RequestModel::whereIn('requests.id', array_merge($requestedIds,$receivedIds))
            ->join('users', 'users.id' ,'=', 'requests.from_user_id')
            ->where('users.id','!=',Auth::user()->id)->count();

        $requestedDataSentCount = RequestModel::where('from_user_id', '=', Auth::user()->id)
            ->join('users', 'users.id' ,'=', 'requests.to_user_id')
            ->where('requests.status','!=', 'accepted')->count();

        $requestedDataReceivedCount = RequestModel::where('to_user_id', '=', Auth::user()->id)
            ->join('users', 'users.id' ,'=', 'requests.from_user_id')
            ->where('requests.status','!=', 'accepted')->count();

        $requestedIds = RequestModel::where('from_user_id', '=', Auth::user()->id)->get()->pluck(['to_user_id'])->toArray();
        $receivedIds = RequestModel::where('to_user_id', '=', Auth::user()->id)->get()->pluck(['from_user_id'])->toArray();
        
        $suggestedUsersCount = User::where('id','!=',Auth::user()->id)
            ->whereNotIn('id', array_merge($requestedIds,$receivedIds))
            ->count();

        $counts = [
            'collection' => $acceptedDataCount,
            'request' => $requestedDataSentCount,
            'received' => $requestedDataReceivedCount,
            'suggestion' => $suggestedUsersCount
        ];

        return \Response::json($counts);
    }
}
