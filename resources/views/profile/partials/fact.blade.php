{{-- resources/views/profile.blade.php --}}
<section  class="space-y-6 text-[white]">
<h2>Двухфакторная аутентификация</h2>
    @if (auth()->user()->two_factor_secret)
        <p>2FA включена.</p>

        <form method="POST" action="/user/two-factor-authentication">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-[transparent] rounded-[5px] w-[10dvw] border-[#9370db] border-[1px] border-[solid] h-[auto] text-[white] font-bold">Отключить двухфакторную аутентификацию</button>
        </form>

        <h4>QR-код для Google Authenticator:</h4>
        @if (auth()->user()->two_factor_secret)
            <h4>Сканируйте QR-код в приложении Google Authenticator:</h4>
            {!! auth()->user()->twoFactorQrCodeSvg() !!}
        @endif
        <h4>Резервные коды:</h4>
            @php
                $codes = auth()->user()->recoveryCodes();
            @endphp

            <ul>
                @foreach ($codes as $code)
                    <li>Код: {{ $code }}</li>
                @endforeach
            </ul>
        <form method="POST" action="/user/two-factor-recovery-codes">
            @csrf
            <button type="submit" class="bg-[transparent] rounded-[5px] w-[10dvw] border-[#9370db] border-[1px] border-[solid] h-[auto] text-[white] font-bold">Обновить резервные коды</button>
        </form>
    @else
        <p>2FA отключена.</p>

        <form method="POST" action="/user/two-factor-authentication">
            @csrf
            <button type="submit" class="bg-[transparent] rounded-[5px] w-[10dvw] border-[#9370db] border-[1px] border-[solid] h-[auto] text-[white] font-bold">Включить 2FA</button>
        </form>
    @endif

</section>
