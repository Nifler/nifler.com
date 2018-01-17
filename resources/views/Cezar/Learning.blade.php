<form action="{{ route('cezarLearning.store') }}" method="post">
    {{ csrf_field() }}
    <p>Language</p>
    <input type="radio" name="key" value="en" > - en <br>
    <p>Text for learning</p>
    <textarea name="text"></textarea> <br>
    <input type="submit" value="Send">
</form>