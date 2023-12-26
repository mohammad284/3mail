@include('dashboard.layouts.header')

<div class="page-wrapper">
    <div class="container">
        <div class="row">

        <div class="col-12">
            <h2 class="main-title">
                حسابات المستخدمين:
            </h2>

            @if(count($users) == 0)
                    <div class="alert alert-info col-12" role="alert">
                        لا يوجد تسجيلات  دخول حاليا!
                    </div>
            @else

            <div class="table-responsive">
                <table class="table table-striped custom-table">
                    <thead>
                        
                    <tr>
                        <th>clientIP</th>
                        <th>browser </th>
                        <th>platform</th>
                        <th>time</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>
                        <td>{{$user->clientIP}}</td>
                        <td>{{$user->browser}}</td>
                        <td>{{$user->platform}}</td>
                        <td>{{$user->time}}</td>
                    @endforeach
                    </tbody>
                </table>
            </div>    

            <div class="col-12">
                {{ $users->links() }}
            </div>

            @endif

        </div>

        </div>
    </div>
</div>

@include('dashboard.layouts.footer')