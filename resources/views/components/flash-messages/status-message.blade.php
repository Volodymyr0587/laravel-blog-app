@if (session()->has('status'))
<p x-data="{show:true}" x-init="setTimeout(() => show = false, 4000)" x-show="show"
    style="color: #fff; width:100%;font-size:18px;font-weight:600;text-align:center;background:#5cb85c;padding:17px 0;margin-bottom:6px;">
    {{ session('status') }}
</p>
@endif
