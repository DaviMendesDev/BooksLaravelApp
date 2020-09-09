
@if (! $isForListItem && ! $isForVisualization)
    <script>
        // runs when this document (html) is completely loaded
        $(document).ready(function () {
            $('#cover').change(function (evt) {
                var tgt = evt.target, files = tgt.files;

                var fr = new FileReader();
                fr.onload = function () {
                    $('#bookCover').attr('src', fr.result);
                }
                fr.readAsDataURL(files[0]);
            })
        });

    </script>
    <div class=" form-group ">
        <label class="w-100">
            <img
                src="@if($isForCreation){{ Storage::url('public/images/default-cover-book.png') }}@else{{ Storage::url($book->cover) }}@endif"
                id="bookCover" class="rounded mx-auto d-block" width="200" height="150">
                <input class="form-control" type="file" name="cover" id="cover" hidden>
        </label>
    </div>

    <div class=" form-group ">
        <label for="title">Title</label>
            <input class="form-control" type="text" name="title" id="title"
            value="@if($isForCreation){{ old('title') }}@else{{ $book->title }}@endif"
            placeholder="Ex.: Deno - A Complete Guide to Programming With Deno">

    </div>

    <div class=" form-group ">
        <label  class="w-100">Author
                <input class="form-control" type="text" name="author"
                value="@if($isForCreation){{ old('author') }}@else{{ $book->author }}@endif"
                id="author" placeholder="Ex.: Ernest Hemingway, Dennis Ritchie, etc..">

                <small class="form-text text-muted">
                    If there's more than one author, you can put their names
                    separated by a comma. Ex.: "Dennis Ritchie, Ken Thompson"
                </small>

        </label>
    </div>

    <div class="row">
        <div class=" form-group  col-sm">
            <label for="edition">Edition</label>
                <input class="form-control" type="text"
                name="edition" id="edition"
                value="@if($isForCreation){{ old('edition') }}@else{{ $book->edition }}@endif"
                placeholder="Ex.: 3rd edition">

        </div>

        <div class=" form-group  col-sm">
            <label for="year">Release Year</label>
                <input class="form-control" type="text"
                name="year" id="year"
                value="@if($isForCreation){{ old('year') }}@else{{ $book->year }}@endif"
                placeholder="Ex.: 2017">

        </div>

        <div class=" form-group  col-sm">
            <label for="page_numbers">Pages</label>
                <input class="form-control" type="text"
                name="page_numbers" id="page_numbers"
                value="@if($isForCreation){{ old('page_numbers') }}@else{{ $book->page_numbers }}@endif"
                placeholder="Ex.: 2495">

        </div>
    </div>

    <div class="row">
        <div class=" form-group  col-sm">
            <label for="category" class="w-100">Category</label>
                    <input class="form-control" type="text" name="category"
                    id="category" placeholder="Ex.: Horror, Comedy, Suspense, etc."
                    value="@if($isForCreation){{ old('category') }}@else{{ $book->category }}@endif">

                    <small class="form-text text-muted">
                        Make sure that this category exists before put in
                    </small>

        </div>

        <div class=" form-group  col-sm">
            <label for="publishing_company" class="w-100">Publishing Company</label>
                <input class="form-control" type="text"
                name="publishing_company" id="publishing_company"
                value="@if($isForCreation){{ old('publishing_company') }}@else{{ $book->publishing_company }}@endif"
                placeholder="Ex.: Wiley, McGrawHill, etc..">

        </div>
    </div>

    <div class=" form-group ">
        <label class="w-100">
                Synopsis <small class="text-muted form-text inline-text">(max characteres: 500)</small>


                <textarea class="form-control" type="text" name="synopsis" id="synopsis"
                    placeholder="Ex.: Harry is a little boy when magic things starts happen..">@if($isForCreation){{ old('synopsis') }}@else{{ $book->synopsis }}@endif</textarea>

        </label>
    </div>


    <div class="row">
        <input type="submit" value="Confirmar" class="form-control col-sm">

        <input type="reset" value="Cancelar" class="form-control col-sm">
    </div>
@endif

@if ($isForVisualization)
    @isset($book)
        <div class="card-body d-flex">
            <div class="row">
                <div class="col-sm my-2">
                    <img src="{{ Storage::url($book->cover) }}" alt=""
                        width="200" height="200">
                </div>
                <div class="card-title col-sm">
                    <h2>
                        <strong> Title:
                            <p class="text-muted"> {{ $book->title }} </p>
                        </strong>
                    </h2>
                </div>
                @auth
                    @if($book->isThisUserThePublisher(auth()->user()))
                        <div class="col-sm-2">
                            <a class="text-white" href="{{ route('edit-book', ['book' => $book]) }}">
                                <button type="button" class="btn btn-primary text-white">
                                    Edit
                                </button>
                            </a>
                        </div>

                        <div class="col-sm-2">
                            <button type="button" class="btn btn-primary text-white" data-toggle="modal" data-target="#deleteModal">
                                Delete
                            </button>
                        </div>

                        <div class="modal" id="deleteModal" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title">Modal title</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <p>Are you sure that you want delete this book?</p>
                                </div>
                                <div class="modal-footer">
                                    <form action="{{ route('delete-book', ['book' => $book]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" class="btn btn-primary text-white" value="Yes"/>
                                        <button type="button" class="btn btn-secondary text-white" data-dismiss="modal">Close</button>
                                    </form>
                                </div>
                              </div>
                            </div>
                          </div>
                    @endif
                @endauth

                <div class="row w-100">
                    <div class="col-sm-6">
                        <strong> Category: </strong>
                        <p class="text-muted">{{ $book->category }} </p>
                    </div>

                    <div class="col-sm-6">
                        <strong> Publishing Company: </strong>
                        <p class="text-muted">{{ $book->publishing_company }}</p>
                    </div>

                    <div class="col-sm-12">
                        <strong> Author: </strong>
                        <p class="text-muted">{{ $book->author }}</p>
                    </div>

                    <div class="col-sm-4">
                        <strong> Edition: </strong>
                        <p class="text-muted">{{ $book->edition }}</p>
                    </div>
                    <div class="col-sm-4">
                        <strong> Year: </strong>
                        <p class="text-muted">{{ $book->year }}</p>
                    </div>
                    <div class="col-sm-4">
                        <strong> Pages: </strong>
                        <p class="text-muted">{{ $book->page_numbers }}</p>
                    </div>

                    <div class="col-sm">
                        <strong> Sysnopsis: </strong>
                        <p class="text-muted">{{ $book->synopsis }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endisset
@endif

@if ($isForListItem)
    @isset($book)
        <div class="card-body h-100 border-top d-flex bg-light">
            <div>
                <img src="{{ Storage::url($book->cover) }}"
                    class="rounded" width="150" height="130">
            </div>

            <div class="d-block m-3">
                <div class="row w-100">
                    <div class="card-title col-sm">
                        <strong>{{ $book->title }}</strong> <br>
                        <small class="card-text">{{ $book->author }}</small>
                    </div>

                    <div class="float-right col-sm">
                        <div class="text-right">
                            <strong>Category: </strong> {{ $book->category }}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <p class="col-sm">
                        <strong> Pages: </strong> {{ $book->page_numbers }}
                    </p>
                    <p class="col-sm">
                        <strong> Year: </strong>{{ $book->year }}
                    </p>
                    <p class="col-sm h-0">
                        <strong> Edition: </strong> {{ $book->edition }}
                    </p>
                </div>
            </div>
            <a href="{{ route('get-book', ['book' => $book]) }}"
                class="stretched-link"></a>
        </div>
    @endisset
@endif
