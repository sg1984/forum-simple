<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ThreadController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->middleware('auth');

        $thread = new Thread();
        return view('threads.edit', ['thread' => $thread]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->middleware('auth');
        try {
            \DB::beginTransaction();
            $request = $request->merge(['user_id' => Auth::user()->id]);
            $thread = Thread::updateOrCreate(
                $request->only(['id']),
                $request->only(['user_id', 'category', 'title', 'body'])
            );

            \DB::commit();

            return redirect()->route('thread.show', [$thread]);
        }
        catch (\Exception $e) {
            \DB::rollback();
            session()->put('error', $e->getMessage());

            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show(Thread $thread)
    {
        return view('threads.show', compact('thread'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        return view('threads.edit', ['thread' => $thread]);
    }

    public function reply(Request $request, Thread $thread)
    {
        try {
            \DB::beginTransaction();
            $reply['body'] = $request->get('body');
            $reply['user_id'] = Auth::user()->id;
            $thread->addReply($reply);

            \DB::commit();

            return redirect()->route('thread.show', [$thread]);
        }
        catch (\Exception $e) {
            \DB::rollback();
            session()->put('error', $e->getMessage());

            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thread $thread)
    {
        $thread->delete();

        return redirect()->route('home');
    }

    public function category($category)
    {
        $threads = Thread::byCategory($category)
            ->latest()
            ->paginate(20);
        $categories = Thread::getAllCategories();

        return view('threads.index', compact('threads', 'categories', 'category'));
    }

    public function search(Request $request)
    {
        $searchTerm = $request->get('search');
        $threads = Thread::bySearch($searchTerm)
            ->latest()
            ->paginate(20);
        $categories = Thread::getAllCategories();

        return view('threads.index', compact('threads', 'categories', 'searchTerm'));
    }
}
