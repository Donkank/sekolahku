<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>SD No. 1 Kekeran</title>
    <style>
        * {
            margin: 0;
            font-family: helvetica neue, Helvetica, Arial, sans-serif;
            box-sizing: border-box;
            font-size: 14px
        }

        img {
            max-width: 100%
        }

        body {
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: none;
            width: 100% !important;
            height: 100%;
            line-height: 1.6em
        }

        table td {
            vertical-align: top
        }

        body {
            background-color: #ecf0f5;
            color: #6c7b88
        }

        .body-wrap {
            background-color: #ecf0f5;
            width: 100%
        }

        .container {
            display: block !important;
            max-width: 600px !important;
            margin: 0 auto !important;
            clear: both !important
        }

        .content {
            max-width: 600px;
            margin: 0 auto;
            display: block;
            padding: 20px
        }

        .main {
            background-color: #fff;
            border-bottom: 2px solid #d7d7d7
        }

        .content-wrap {
            padding: 20px
        }

        .content-block {
            padding: 0 0 20px
        }

        .header {
            width: 100%;
            margin-bottom: 20px
        }

        .footer {
            width: 100%;
            clear: both;
            color: #999;
            padding: 20px
        }

        .footer p,
        .footer a,
        .footer td {
            color: #999;
            font-size: 12px
        }

        h1,
        h2,
        h3 {
            font-family: helvetica neue, Helvetica, Arial, lucida grande, sans-serif;
            color: #1a2c3f;
            margin: 30px 0 0;
            line-height: 1.2em;
            font-weight: 400
        }

        h1 {
            font-size: 32px;
            font-weight: 500
        }

        h2 {
            font-size: 24px
        }

        h3 {
            font-size: 18px
        }

        h4 {
            font-size: 14px;
            font-weight: 600
        }

        p,
        ul,
        ol {
            margin-bottom: 10px;
            font-weight: 400
        }

        p li,
        ul li,
        ol li {
            margin-left: 5px;
            list-style-position: inside
        }

        a {
            color: #348eda;
            text-decoration: underline
        }

        .btn-primary {
            text-decoration: none;
            color: #fff;
            background-color: #42a5f5;
            border: solid #42a5f5;
            border-width: 10px 20px;
            line-height: 2em;
            font-weight: 700;
            text-align: center;
            cursor: pointer;
            display: inline-block;
            text-transform: capitalize
        }

        .last {
            margin-bottom: 0
        }

        .first {
            margin-top: 0
        }

        .aligncenter {
            text-align: center
        }

        .alignright {
            text-align: right
        }

        .alignleft {
            text-align: left
        }

        .clear {
            clear: both
        }

        .alert {
            font-size: 16px;
            color: #fff;
            font-weight: 500;
            padding: 20px;
            text-align: center
        }

        .alert a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            font-size: 16px
        }

        .alert.alert-warning {
            background-color: #ffa726
        }

        .alert.alert-bad {
            background-color: #ef5350
        }

        .alert.alert-good {
            background-color: #8bc34a
        }

        .invoice {
            margin: 25px auto;
            text-align: left;
            width: 100%
        }

        .invoice td {
            padding: 5px 0
        }

        .invoice .invoice-items {
            width: 100%
        }

        .invoice .invoice-items td {
            border-top: #eee 1px solid
        }

        .invoice .invoice-items .total td {
            border-top: 2px solid #6c7b88;
            font-size: 18px
        }

        .text-wrap td {
            width: 11em;
            word-wrap: break-word;
        }

        @media only screen and (max-width:640px) {
            body {
                padding: 0 !important
            }

            h1,
            h2,
            h3,
            h4 {
                font-weight: 800 !important;
                margin: 20px 0 5px !important
            }

            h1 {
                font-size: 22px !important
            }

            h2 {
                font-size: 18px !important
            }

            h3 {
                font-size: 16px !important
            }

            .container {
                padding: 0 !important;
                width: 100% !important
            }

            .content {
                padding: 0 !important
            }

            .content-wrap {
                padding: 10px !important
            }

            .invoice {
                width: 100% !important
            }
        }
    </style>
</head>

<body>

    <table class="body-wrap">
        <tr>
            <td></td>
            <td class="container" width="600">
                <div class="content">
                    <table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" itemscope>
                        <tr>
                            <td class="content-wrap">
                                <meta itemprop="name" content="Verification Email" />
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td class="content-block aligncenter">
                                            <img width="18%" src="{{ asset('img/logo-sekolah.png') }}">
                                            <h3>{{ strtoupper(config('app.name')) }}</h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content-block">
                                            <h3>Hai {{ $mailData['name'] }}!</h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content-block">
                                            Terima kasih telah mendaftar. Tautan konfirmasi yang disertakan dalam email
                                            akan kedaluwarsa dalam satu jam setelah pengiriman. Harap gunakan link
                                            tersebut untuk mengaktifkan akun Anda dalam waktu yang ditentukan.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content-block">
                                            Harap konfirmasi alamat email Anda dengan mengklik link di bawah ini.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content-block aligncenter" itemprop="handler" itemscope>
                                            <a href="https://sdno1kekeran.sch.id/user_verify?token={{ $mailData['token'] }}"
                                                class="btn-primary" target="_blank" style="color:#fff;">Confirm Your
                                                Email</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content-block">
                                            Kami mungkin perlu mengirimi Anda informasi penting tentang layanan kami dan
                                            penting bagi kami untuk memiliki alamat email yang akurat.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content-block">
                                            <br>
                                            Salam,
                                            <br><br>
                                            Admin
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <div class="footer">
                        <table width="100%">
                            <tr>
                                <td class="aligncenter content-block">
                                    Anda menerima email ini karena kami menerima permintaan
                                    <a href="https://sdno1kekeran.sch.id">registrasi</a> untuk akun email
                                    {{ $mailData['email'] }}. Jika Anda tidak meminta <a
                                        href="https://sdno1kekeran.sch.id">registrasi</a>,
                                    Anda dapat menghapus email ini dengan aman.
                                </td>
                            </tr>
                            <tr>
                                <td class="aligncenter content-block">
                                    <p>{{ strtoupper(config('app.name')) }}<br>
                                        {{ config('app.address') }}</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </td>
            <td></td>
        </tr>
    </table>

</body>

</html>
