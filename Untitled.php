<?php
 use App\Models\PostCategory;
 use Carbon\Carbon;

$name = "Blog";
$post = PostCategory::where('name', 'like', '%' . $name . '%')->first()->id;



posts = $this->postService->getPosts(5, [
          'status' => 'published',
          'category_id' => $blogCategoryId,
        ]);