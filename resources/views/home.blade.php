@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (\Session::has('msg'))
                        <div class="alert alert-{!! Session::get('msgc') !!} alert-dismissible fade show" role="alert">
                            {!! Session::get('msg') !!}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                    @endif
                    @foreach ($msg->reverse() as $besked)
                        <div class="alert alert-{{ $besked->color }} alert-dismissible fade show" role="alert">
                            {{ $besked->text }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                    @endforeach
                    <div>
                        <ul class="nav nav-pills nav-justified">
                            <li class="nav-item"><a role="tab" data-toggle="pill" href="#tab-1"
                                    class="nav-link active">Products</a></li>
                            <li class="nav-item"><a role="tab" data-toggle="pill" href="#tab-2"
                                    class="nav-link">Profile</a></li>
                            @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('vip'))
                            <li class="nav-item"><a role="tab" data-toggle="pill" href="#tab-3"
                                    class="nav-link">Admin</a></li>
                            @endif
                            @if (Auth::user()->hasRole('user'))
                            <li class="nav-item"><a role="tab" data-toggle="pill" href="#tab-3"
                                    class="nav-link disabled">Admin</a></li> <!-- disabled -->
                            @endif
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade show active" id="tab-1">
                                <br>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Description</th>
                                            <th>Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($product->reverse() as $item)
                                            <tr>
                                                <td>{{ $item->title }}</td>
                                                <td>{{ $item->description }}</td>
                                                <td> {{ $item->price }} kr</td>
                                                <td>
                                                    @if ($item->uid != 0)
                                                        Sold
                                                    @endif
                                                    @if ($item->uid == 0)
                                                        <a onclick="return confirm('Are you sure that you wanna buy this item?')"
                                                            href="{{ url('/buy-item/'.$item->id.'/'.Auth::user()->id) }}">Buy</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="tab-2">
                                <br>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Created At</th>
                                            <th>Delete Account</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ Auth::user()->name }}</td>
                                            <td>{{ Auth::user()->email }}</td>
                                            <td>{{ Auth::user()->Role->display_name }}</td>
                                            <td>{{ Auth::user()->created_at }}</td>
                                            <td>
                                                @if (Auth::user()->hasRole('admin'))
                                                @endif
                                                @if (Auth::user()->hasRole('user') || Auth::user()->hasRole('vip'))
                                                    <a onclick="return confirm('Are you sure that you wanna delete your account?')"
                                                        href="{{ url('/delete-account/'.Auth::user()->id) }}">Delete</a>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                @foreach ($product as $item)
                                @if (Auth::user()->id == $item->uid)
                                        <br>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Purchases</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($product->reverse() as $item)
                                                    <tr>
                                                        <td>{{ $item->title }}</td>
                                                        <td>{{ $item->description }}</td>
                                                        <td> {{ $item->price }} kr</td>
                                                        <td>
                                                                <a onclick="return confirm('Are you sure that you wanna delete this product?')"
                                                                href="{{ url('/delete-product/'.$item->id) }}">Delete</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                @endforeach
                                @if ($timer->count() > 0)
                                    <br>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>User</th>
                                                <th>Total Hours</th>
                                                <th>In Time</th>
                                                <th>Out Time</th>
                                                <th>Date</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($timer->reverse() as $item)
                                            @if (Auth::user()->id == $item->user)
                                            <tr>
                                                <td>{{ $item->user }}</td>
                                                <td>{{ $item->totalHours }}</td>
                                                <td>{{ substr_replace($item->inTime, ":", -2, 0) }}</td>
                                                <td>{{ substr_replace($item->outTime, ":", -2, 0) }}</td>
                                                <td>{{ substr_replace($item->date, "-", -2, 0) }}</td>
                                                <td>
                                                    @if (Auth::user()->hasRole('user') || Auth::user()->hasRole('vip') || Auth::user()->hasRole('admin'))
                                                        <a onclick="return confirm('Are you sure that you wanna delete this time?')"href="{{ url('/delete-time/'.$item->id) }}">Delete</a>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                            @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('vip'))
                                <div role="tabpanel" class="tab-pane fade" id="tab-3">
                                    <br>
                                    <div role="tablist" id="accordion-1">
                                        <div class="card">
                                            <div class="card-header" role="tab">
                                                <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="true"
                                                        aria-controls="accordion-1 .item-1"
                                                        href="#accordion-1 .item-1">Delete Users</a></h5>
                                            </div>
                                            <div class="collapse item-1" role="tabpanel" data-parent="#accordion-1">
                                                <div class="card-body">
                                                    <table class="table table-striped table-bordered table-hover table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th>Id</th>
                                                                <th>Name</th>
                                                                <th>Email</th>
                                                                <th>Role</th>
                                                                <th>Created at</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($usr as $user)
                                                                <tr>
                                                                    <td>{{ $user->id }}</td>
                                                                    <td>{{ $user->name }}</td>
                                                                    <td>{{ $user->email }}</td>
                                                                    <td>{{ $user->Role->display_name }}</td>
                                                                    <td>{{ $user->created_at }}</td>
                                                                    <td>
                                                                        @if (Auth::user()->hasRole('admin'))
                                                                        @if ($user->hasRole('vip'))
                                                                        <a onclick="return confirm('Are you sure that you wanna DEOP this person?')"
                                                                            href="{{ url('/de-op/'.$user->id) }}">DEOP</a>
                                                                        |
                                                                        <a onclick="return confirm('Are you sure that you wanna delete this person?')"
                                                                            href="{{ url('/delete-user/'.$user->id) }}">Delete</a>
                                                                        @endif
                                                                        @if ($user->hasRole('user'))
                                                                        <a onclick="return confirm('Are you sure that you wanna OP this person?')"
                                                                            href="{{ url('/force-op/'.$user->id) }}">OP</a>
                                                                        |
                                                                        <a onclick="return confirm('Are you sure that you wanna delete this person?')"
                                                                            href="{{ url('/delete-user/'.$user->id) }}">Delete</a>
                                                                        @endif
                                                                        @endif
                                                                        @if (Auth::user()->hasRole('vip'))
                                                                        @if ($user->hasRole('admin'))
                                                                        @endif
                                                                        @if ($user->hasRole('vip'))
                                                                        Can't change
                                                                        @endif
                                                                        @if ($user->hasRole('user'))
                                                                        <a onclick="return confirm('Are you sure that you wanna OP this person?')"
                                                                            href="{{ url('/force-op/'.$user->id) }}">OP</a>
                                                                        |
                                                                        <a onclick="return confirm('Are you sure that you wanna delete this person?')"
                                                                            href="{{ url('/delete-user/'.$user->id) }}">Delete</a>
                                                                        @endif
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" role="tab">
                                                <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false"
                                                        aria-controls="accordion-1 .item-2"
                                                        href="#accordion-1 .item-2">Delete Products</a></h5>
                                            </div>
                                            <div class="collapse item-2" role="tabpanel" data-parent="#accordion-1">
                                                <div class="card-body">
                                                    <table class="table table-striped table-bordered table-hover table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th>Product</th>
                                                                <th>Description</th>
                                                                <th>Price</th>
                                                                <th>Delete</th>
                                                            </tr>
                                                        <tbody>
                                                            @foreach ($product->reverse() as $item)
                                                            <tr>
                                                                <td>{{ $item->title }}</td>
                                                                <td>{{ $item->description }}</td>
                                                                <td> {{ $item->price }} kr</td>
                                                                <td>
                                                                    <a onclick="return confirm('Are you sure that you wanna delete this product?')"
                                                                        href="{{ url('/delete-product/'.$item->id) }}">Delete</a>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" role="tab">
                                                <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false"
                                                        aria-controls="accordion-1 .item-3"
                                                        href="#accordion-1 .item-3">Upload Product</a></h5>
                                            </div>
                                            <div class="collapse item-3" role="tabpanel" data-parent="#accordion-1">
                                                <div class="card-body">
                                                    <form action="{{ URL::to('/upload-item') }}" method="post">
                                                        @csrf
                                                        <h2 class="text-center">Upload Product</h2>
                                                        <div class="form-group">
                                                            <input class="form-control" type="text" name="title"
                                                                placeholder="Title" />
                                                        </div>
                                                        <div class="form-group">
                                                            <input class="form-control" type="number" name="price"
                                                                placeholder="Price (kr)" />
                                                        </div>
                                                        <div class="form-group">
                                                            <textarea class="form-control" rows="2" name="description"
                                                                placeholder="Description"></textarea>
                                                        </div>
                                                        <div class="form-group text-center">
                                                            <button class="btn btn-primary" type="submit">Upload</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" role="tab">
                                                <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false"
                                                        aria-controls="accordion-1 .item-4"
                                                        href="#accordion-1 .item-4">Delete Message</a></h5>
                                            </div>
                                            <div class="collapse item-4" role="tabpanel" data-parent="#accordion-1">
                                                <div class="card-body">
                                                    <table class="table table-striped table-bordered table-hover table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th>Text</th>
                                                                <th>Color</th>
                                                                <th>Delete</th>
                                                            </tr>
                                                        <tbody>
                                                            @foreach ($msg->reverse() as $item)
                                                            <tr>
                                                                <td>{{ $item->text }}</td>
                                                                <td>{{ $item->color }}</td>
                                                                <td>
                                                                    <a onclick="return confirm('Are you sure that you wanna delete this product?')"
                                                                        href="{{ url('/delete-msg/'.$item->id) }}">Delete</a>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" role="tab">
                                                <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false"
                                                        aria-controls="accordion-1 .item-5"
                                                        href="#accordion-1 .item-5">Send Message</a></h5>
                                            </div>
                                            <div class="collapse item-5" role="tabpanel" data-parent="#accordion-1">
                                                <div class="card-body">
                                                    <form action="{{ URL::to('/upload-msg') }}" method="post">
                                                        @csrf
                                                        <h2 class="text-center">Send Global Message</h2>
                                                        <div class="form-group">
                                                            <input class="form-control" type="text" name="text"
                                                                placeholder="Text" />
                                                        </div>
                                                        <div>
                                                            <select id="inputState" class="form-control" name="color">
                                                                    <option selected>primary</option>
                                                                    <option>secondary</option>
                                                                    <option>success</option>
                                                                    <option>danger</option>
                                                                    <option>warning</option>
                                                                    <option>info</option>
                                                                    <option>light</option>
                                                                    <option>dark</option>
                                                            </select>
                                                        </div>
                                                        <br>
                                                        <div class="form-group text-center">
                                                            <button class="btn btn-primary" type="submit">Send</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
