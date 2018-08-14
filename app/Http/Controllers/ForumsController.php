<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Discussion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;

class ForumsController extends Controller
{
    public function index()
	{
//		$discussions = Discussion::orderBy('created_at', 'desc')->paginate(3);

		switch(\request('filter')){
			case 'me':
				$result = Discussion::where('user_id', Auth::id())->paginate(3);
				break;
			case 'closed':
				$answered = [];
				foreach(Discussion::all() as $d){
					if($d->has_best_answer()){
						array_push($answered, $d);
					}
				}
				$result = new Paginator($answered, 3);
				break;
			case 'open':
				$unanswered = [];
				foreach(Discussion::all() as $d){
					if(!$d->has_best_answer()){
						array_push($unanswered , $d);
					}
				}
				$result = new Paginator($unanswered , 3);
				break;
			default:
				$result = Discussion::orderBy('created_at', 'desc')->paginate(3);
				break;
		}
		return view('forum', ['discussions' => $result]);
	}

	public function channel($slug)
	{
		$channel = Channel::where('slug', $slug)->first();

		return view('channel', ['discussions' => $channel->discussions()->paginate(5)]);
	}
}
