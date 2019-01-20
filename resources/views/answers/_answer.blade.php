<div class="media post">
    @include('shared._vote', ['model' => $answer])

    <div class="media-body">
        {!! $answer->body_html !!}
        <div class="row mt-2">
            <div class="col-4">
                <div class="ml-auto">
                    @can('update', $answer)
                    <a href="{{ route('questions.answers.edit', [$question->id, $answer->id]) }}" class="btn btn-sm btn-outline-info">
                        <i class="fa fa-edit fa-2x"> Edit</i>
                    </a>
                    @endcan

                    @can('delete', $answer)
                    <form class="form-delete" action="{{ route('questions.answers.destroy', [$question->id, $answer->id]) }}" method="post">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                            <i class="fa fa-trash-alt fa-2x"> Delete</i>
                        </button>
                    </form>
                    @endcan
                </div>
            </div>
            <div class="col-4">
            </div>
            <div class="col-4">
                <user-info :model="{{ $answer }}" label="Answered"></user-info>
            </div>
        </div>
    </div>
</div>