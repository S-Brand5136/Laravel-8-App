<?php

namespace App\Models;

use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class Post
{
    public $title, $excerpt, $date, $body, $slug;

    public function __construct(
        $title,
        $excerpt,
        $date,
        $body,
        $slug
    ) {

        $this->title = $title;
        $this->excerpt = $excerpt;
        $this->date = $date;
        $this->body = $body;
        $this->slug = $slug;
    }

    public static function all()
    {
        return cache()->rememberForever('posts.all', function () {
            return collect(File::files(resource_path("posts")))
                ->map(function ($file) {
                    return YamlFrontMatter::parseFile($file);
                })
                ->map(function ($document) {
                    return $posts[] = new Post(
                        $document->title,
                        $document->excerpt,
                        $document->date,
                        $document->body(),
                        $document->slug
                    );
                })
                ->sortByDesc('date');
        });
    }

    public static function find($slug)
    {
        // of all the blog posts with a slug that matches the one that was requested.
        return static::all()->firstWhere('slug', $slug);
    }
}