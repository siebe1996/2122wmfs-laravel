<div class="col-md-4">
    <div class="position-sticky" style="top: 2rem;">
        <div class="p-4 mb-3 bg-light rounded">
            <h4 class="fst-italic">About</h4>
            <p class="mb-0">Customize this section to tell your visitors a little bit about your publication, writers, content, or something else entirely. Totally up to you.</p>
        </div>

        <div class="p-4">
            <h4 class="fst-italic">Most recent</h4>
            <ol class="list-unstyled mb-0">
                @foreach($recentBlogposts as $recentBlogpost)
                <li><a href="{{ url('blogposts/'.$recentBlogpost->id) }}" >{{ $recentBlogpost->title }}</a></li>
                @endforeach
            </ol>
        </div>

    </div>
</div>
