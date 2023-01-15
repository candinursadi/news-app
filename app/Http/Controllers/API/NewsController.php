<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;
use Utilities;
use App\Models\NewsList;
use App\Models\NewsComment;
use App\Models\NewsListLog;
use App\Events\NewsLogEvent;
use App\Jobs\PostCommentJob;
use App\Http\Resources\NewsResource;
use App\Http\Resources\NewsListResource;

class NewsController extends Controller
{
    function getList(Request $request) {
        try {
            $per_page = $request->per_page ?? 10;

            $news = NewsList::query()
                ->selectRaw("id, author, title, CONCAT(?, '/', image) as image, content, posted_by, created_at", [url('/')])
                ->orderBy('id', 'desc')
                ->paginate($per_page);

        } catch(\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }

        return new NewsListResource($news);
    }

    function getDetail(Request $request, $id=null) {
        try {
            $news = NewsList::find($id);
            if(!$news) throw new \Exception ('News not found', 400);
            $news->image = url($news->image);

            $data = $news;
            $data->comments = $news->comments;

        } catch(\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }

        return new NewsResource($data, 'Success');
    }

    function create(Request $request) {
        $error = Utilities::newsValidate($request->all());
        if($error) {
            return response()->json([
                'error' => $error
            ], 400);
        }

        DB::beginTransaction();
        try {
            $user = Auth::user();
            if(!$user->is_admin) throw new \Exception ('Only admin has permission', 400);

            $image = $request->file('image');
            $folder = 'news_images';
            $path = Utilities::uploadImage($image, $folder);

            $input = $request->all();
            $input['image'] = $path;
            $input['posted_by'] = $user->id;
            $news = NewsList::create($input);

            event(new NewsLogEvent($news, 'CREATE'));

            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();

            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }

        return new NewsResource($news, 'News successfully created');
    }

    function update(Request $request, $id=null) {
        $error = Utilities::newsValidate($request->all());
        if($error) {
            return response()->json([
                'error' => $error
            ], 400);
        }

        DB::beginTransaction();
        try {
            $user = Auth::user();
            if(!$user->is_admin) throw new \Exception ('Only admin has permission', 400);

            $news = NewsList::find($id);
            if(!$news) throw new \Exception ('News not found', 400);

            $image = $request->file('image');
            $folder = 'news_images';
            $path = Utilities::uploadImage($image, $folder);

            $news->author       = $request->author;
            $news->title        = $request->title;
            $news->image        = $path;
            $news->content      = $request->content;
            $news->posted_by    = $user->id;
            $news->save();

            event(new NewsLogEvent($news, 'UPDATE'));

            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();

            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }

        return new NewsResource($news, 'News successfully updated');
    }

    function delete(Request $request, $id=null) {
        try {
            $user = Auth::user();
            if(!$user->is_admin) throw new \Exception ('Only admin has permission', 400);

            $news = NewsList::find($id);
            if(!$news) throw new \Exception ('News not found', 400);
            $news->delete();

            event(new NewsLogEvent($news, 'DELETE'));

        } catch(\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }

        return new NewsResource($news, 'News successfully deleted');
    }

    function createComment(Request $request, $id=null) {
        $validator = Validator::make($request->all(), [
            'message' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 400);
        }

        try {
            $user = Auth::user();
            $news = NewsList::find($id);
            if(!$news) throw new \Exception ('News not found', 400);

            $data = [
                'user_id' => $user->id,
                'news_list_id' => $news->id,
                'message' => $request->message
            ];

            PostCommentJob::dispatch($data);

        } catch(\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }

        return new NewsResource($data, 'Comment added successfully');
    }
}
