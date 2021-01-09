<body>
<style>

    /**
 * This stylesheet ensures that the .paper-page container is the only thing that is
 * printed out. The goal is to make the printed copy as close to what is shown
 * in the .paper-page container.
 *
 * The styles here are as barebones as possible and theming is left for another
 * stylesheet to do.
 */

    html {
        /* In order for the print stylesheet to work, the font size must be over 16px
           so that the page fills up the whole printed area. It is a bit hacky, but
           until a more elegant solution is found, this will be here.

           20px is a easily divisible number and makes the paper size end up as a
           simple 850x1100px.
        */
        font-size: 20px;

        /* iOS text size */
        -ms-text-size-adjust: 100%;
        -webkit-text-size-adjust: 100%;
    }
    body {
        margin: 0;
    }

    /**
     * .paper-page is the container that actually holds the page itself. When
     * printed, the result should be as close to what is shown on the browser
     * as possible.
     */
    .paper-page {
        /* Unfortunately, setting the page to 85em*110em makes the printing not work.
           10em = 0.5inches */
        width: 42.5em;
        height: 55em;
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        margin: 0 auto;

        /* In real life, if one writes past the borders of the paper, the stuff ends
           up on the table or writing surface, not the paper. Similarly here,
           anything that flows outside the page should not be printed. As of right
           now, there is only support for single pages. */
        overflow: hidden;
    }

    .paper-page article {
        /* If position: absolute; is used on an element in the page inside the content,
           it will snap to the boundaries of the margins. */
        position: relative;
    }

    @media print {
        @page {
            /* For different page sizes, the width and height of .paper-page also needs to be changed */
            size: 8.5in 11in;
            /* this affects the margin in the printer settings. Set to 0 so that another
               stylesheet can decide how big they want to margins to be */
            margin: 0;
        }

        /* We only want to print out the stuff in .paper-page. Everything else will be
           gone. Unfortunately, if there is text that is directly a child of <body>
           and is not wrapped in any tags, it will show. */
        body > * {
            display: none;
        }
        .paper-page {
            display: block;
        }
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }
    th {
        padding: 2px 2px 2px;
    }
    td {
        padding: 10px 10px 10px;
    }



</style>
<div class="paper-page">
    <h4 align="center">JADWAL {{strtoupper(\App\Casts\ScheduleType::lang($type))}} <br>PROGRAM STUDI ILMU KOMUNIKASI</h4>
    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Hari / Tgl</th>
                <th>Waktu</th>
                <th>Nama Mahasiswa</th>
                <th>NIM</th>
                <th>Pembimbing</th>
                <th>Pemimpin Sidang (Penguji)</th>
                <th>Penguji</th>
            </tr>
        </thead>
        <tbody>
        @foreach($jadwal as $k => $r)
            <tr>
                <td align="center">{{$k+1}}</td>
                <td>{{$r->start_date->format("d/m/Y")}}</td>
                <td>{{$r->start_time}} - {{$r->end_time}}</td>
                <td>{{$r->user->name}}</td>
                <td>{{$r->user->username}}</td>
                <td>{{@$r->pembimbing->name}}</td>
                <td>{{@$r->penguji_satu->name}}</td>
                <td>{{@$r->penguji_dua->name}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
