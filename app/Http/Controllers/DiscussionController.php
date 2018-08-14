<?php

namespace App\Http\Controllers;
use App\Discussion;
use App\Notifications\NewReplyAdded;
use Illuminate\Support\Facades\Notification;
use App\Reply;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DiscussionController extends Controller
{
    public function create()
	{
    	return view('discussions.create');
	}

	public function store()
	{
		$r = \request();
    	$this->validate($r, [
    		'channel_id' => 'required',
    		'content' => 'required',
    		'title' => 'required'
		]);

    	$discussion = Discussion::create([
    		'title' => $r->title,
    		'channel_id' => $r->channel_id,
    		'content' => $r->content,
    		'user_id' => Auth::id(),
    		'slug' => str_slug($r->title)
		]);

    	Session::flash('success', 'Discussion successfully created');

    	return redirect()->route('discussion', ['slug' => $discussion->slug]);
	}

	public function show($slug)
	{
		$d = Discussion::where('slug', $slug)->first();
		$best_answer = $d->replies()->where('best_answer', 1)->first();

		return view('discussions.show')->with('d', $d)->with('best_answer', $best_answer);
	}

	public function reply($id)
	{
		$d = Discussion::find($id);
//		dd(\request());
		$reply = Reply::create([
			'user_id' => Auth::id(),
			'discussion_id' => $id,
			'content' => \request()->reply
		]);

		$watchers = array();

		foreach($d->watchers as $w):
			array_push($watchers, User::find($w->user_id));
		endforeach;

		Notification::send($watchers, new NewReplyAdded($d));
		Session::flash('success', 'Replied to discussion');

		return redirect()->back();
	}

	public function edit($slug)
	{
		return view('discussions.edit', ['d' => Discussion::where('slug', $slug)->first()]);
	}

	public function update($id)
	{
		$this->validate(\request(), [
			'content' => 'required'
		]);

		$d = Discussion::find($id);

		$d->content = \request()->content;
		$d->save();
		Session::flash('success', 'Discussion successfully updated');

		return redirect()->route('discussion', ['slug' => $d->slug]);

	}
}
