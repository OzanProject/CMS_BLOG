<x-mail::message>
# New Comment

You have a new comment on your article: **{{ $article->title }}**

**Commenter:** {{ $comment->name }} (<a href="mailto:{{ $comment->email }}">{{ $comment->email }}</a>)
<br>
**Message:**
<div style="background: #f4f4f4; padding: 15px; border-radius: 5px; margin: 10px 0;">
    {{ $comment->body }}
</div>

<x-mail::button :url="route('article.show', $article->slug)">
View Comment
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
