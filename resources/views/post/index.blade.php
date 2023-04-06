@extends('layout.dashboardnav')
@section('title')
Post User
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  $(document).ready(function() {
    $('#createPostyModal').modal({
      show: false
    });

    $('.open-modal-btn').click(function(e) {
      e.preventDefault();
      $('#createPostyModal').modal('show');
    });
  });

  
</script>
 
 
<script>
  $(document).ready(function() {
    $('#createCommentyModal').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget);
      var postId = button.data('postid');
      var modal = $(this);
      modal.find('#post_id').val(postId);
    });
  });
</script>
@section('content')
<br/>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createPostyModal">
    Create Post
  </button>
<br/>
<br/>
<div class="modal fade" id="createPostyModal" tabindex="-1" role="dialog" aria-labelledby="createPostyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createPostyModalLabel">Create Post</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('post.insert', $categoryId) }}" method="POST">
            @csrf
            <div class="form-group">
              <textarea id="body" name="body" placeholder="Type here Your Post" rows="5" cols="40"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="createCommentyModal" tabindex="-1" role="dialog" aria-labelledby="createCommentyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createCommentyModalLabel">Create Comment</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('comment.insert') }}" method="POST">
            @csrf
            <input type="hidden" name="post_id" id="post_id" value="">
            <div class="form-group">
                <textarea id="comment" name="comment" placeholder="Type your comment here" rows="3" cols="40" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
        @foreach($posts as $post)
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <p class="card-text">{{ $post->body }}</p>
                        <small class="text-muted">{{ $post->created_at->format('M d, Y') }}</small>
                        <hr>
                        <button type="button" class="btn btn-primary" data-postid="{{ $post->id }}" data-toggle="modal" data-target="#createCommentyModal">
                          Comment
                        </button>
                        <h6>Comments:</h6>
                        @foreach($post->comments as $comment)
                            <div class="mb-2">
                              @if($comment->user)
                                <strong>{{ $comment->user->name }}</strong>
                              @endif
                                <p>{{ $comment->comment }}</p>
                                <small class="text-muted">{{ $comment->created_at->format('M d, Y') }}</small>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection