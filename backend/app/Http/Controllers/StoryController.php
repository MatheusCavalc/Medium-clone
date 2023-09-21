<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStoryRequest;
use App\Http\Requests\UpdateStoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;
use App\Models\Story;
use App\Models\Follower;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class StoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 3);
        $stories = Story::with('author')->orderBy('id', 'desc')->paginate($perPage);

        return response()->json($stories, 200);
    }

    public function following(Request $request)
    {
        //id from auth user
        $id = auth()->user()->id;

        //ids que o auth user segue
        $ids_follow = Follower::where('follower_user_id', $id)->get();

        // tranformando valores em string para array para consulta
        $content = '';
        foreach ($ids_follow as $a) {
            $content .= $a->user_id . ',';
        }
        $array_follow = explode(',', $content);

        //consulta
        $perPage = $request->input('perPage', 3);

        $stories = DB::table('stories')
            ->whereIn('stories.user_id', $array_follow)
            ->orderBy('stories.id', 'desc')
            ->select('stories.id', 'stories.created_at', 'stories.slug', 'stories.title_preview', 'stories.content_preview', 'stories.image', 'stories.tags', 'users.username', 'users.name')
            ->join('users', 'users.id', '=', 'stories.user_id')
            ->paginate($perPage);

        //retorno
        return response()->json($stories, 200);
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
     * @param  \App\Http\Requests\StoreStoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $slug = Str::slug($request->get('title_preview'), '-');
        $request->request->add(['slug' => $slug]);

        $request->request->add(['user_id' => auth()->user()->id]);
        $request->request->add(['editor_name' => auth()->user()->name]);

        $requestData = $request->validate([
            'slug' => 'required',
            'tags' => 'required',
            'image' => 'nullable',
            'content' => 'required',
            'title_preview' => 'required|max:100',
            'content_preview' => 'required|max:140',
            'user_id' => 'required|max:5000',
            'editor_name' => 'required|max:25'
        ]);

        $requestData['tags'] = explode(',', $request->get('tags'));
        $requestData['content'] = json_decode($request->input('content'));

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . $slug . '.' . $image->getClientOriginalExtension();
            $request->image->move(public_path('storage/image'), $filename);
            $requestData['image'] = $filename;
        }

        $response = [];
        Story::create($requestData);
        array_push($response, ['status' => 'success']);
        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function show(Story $story)
    {
        $id = auth()->user()->id;

        $user = User::select('id', 'name', 'username', 'bio')->where('id', $story->user_id)->first();

        $ids_follow = Follower::where('follower_user_id', $id)->where('user_id', $story->user_id)->exists();

        $can_follow = $id == $story->user_id ? false : true;

        if ($ids_follow) {
            $follow = true;
        } else {
            $follow = false;
        }

        return response()->json([
            'authId' => $id,
            'user' => $user,
            'story' => $story,
            'is_follow' => $follow,
            'can_follow' => $can_follow
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function edit(Story $story)
    {
        $id = auth()->user()->id;

        if ($id == $story->user_id) {
            return response()->json([
                'story' => $story
            ]);
        }

        return response()->json([
            'status' => 'Unauthorized'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStoryRequest  $request
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Story $story)
    {
        $story->update([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
        ]);

        if ($story) {
            return response()->json([
                'status' => 'success',
                'redirect' => $story->slug . '/' . $story->id
            ], 200);
        } else {
            return response()->json([
                'status' => 'error'
            ]);
        }

        /*
        $response = [];
        $validation = $this->validation($request->all());
        if (!is_array($validation)) {
            $product = Product::find($id);
            if ($product) {
                $product->fill($request->all())->save();
                array_push($response, ['status' => 'success']);
            } else {
                array_push($response, ['status' => 'error']);
                array_push($response, ['errors' => ['id' => ['Products not found']]]);
            }
            return response()->json($response);
        } else {
            return response()->json($validation);
        }
        */
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function destroy(Story $story)
    {
        if ($story->user_id === auth()->user()->id) {
            $story->delete();
            return response()->json([
                'status' => 'success',
                "message" => "Story deleted"
            ], 202);
        }
    }

    public function validation($params)
    {
        $response = [];
        $messages = [
            'max' => 'The :attribute field must NOT have more than :max characters',
            'required' => 'The :attribute field must NOT be empty'
        ];
        $attributes = [
            'slug' => 'slug',
            'tags' => 'tags',
            'image' => 'image',
            'content' => 'content',
            'title_preview' => 'title_preview',
            'content_preview' => 'content_preview',
            'user_id' => 'user_id',
            'editor_name' => 'editor_name',
        ];
        $validation = Validator::make(
            $params,
            [
                'slug' => 'required',
                'tags' => 'required',
                'image' => 'nullable',
                'content' => 'required',
                'title_preview' => 'required|max:100',
                'content_preview' => 'required|max:140',
                'user_id' => 'required|max:5000',
                'editor_name' => 'required|max:25'
            ],
            $messages,
            $attributes
        );

        if ($validation->fails()) {
            array_push($response, ['status' => 'error']);
            array_push($response, ['errors' => $validation->errors()]);
            return $response;
        } else {
            return true;
        }
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required'
        ]);

        $picName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('storage/image'), $picName);
        return response()->json([
            "success" => 1,
            "file" => [
                "url" => "http://localhost/storage/image/$picName"
            ]
        ]);
    }
}
