<!-- <div class="container align-items-center">
        <h3 style="font-family: 'Verdana', sans-serif; font-size: 24px; color: #333; text-align: center; padding: 20px; background-color: #fff;">
            Soil Data Management System
        </h3>


    </div> -->

<div class="container align-items-center" style="position: relative; background-color: #fff; padding: 20px;">
    <!-- Heading (centered) -->
    <h3 style="font-family: 'Verdana', sans-serif; font-size: 24px; color: #333; text-align: center;">
        Soil Data Management System
    </h3>

    <!-- Conditionally show Login or Username with Logout Button -->
    @if (Auth::check())
    <div style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); display: flex; align-items: center;">
        <!-- Display user's name -->
        <span style="margin-right: 10px;">
            {{ Auth::user()->name }}
        </span>
        <!-- Logout button -->
        <form action="{{ route('PhpSpreadsheetController.logout') }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit" class="btn">
                Logout
            </button>
        </form>
    </div>
    @else
    <!-- Show Login button if not logged in -->
    <a href="/login" class="btn" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%);">
        Login
    </a>
    @endif
</div>