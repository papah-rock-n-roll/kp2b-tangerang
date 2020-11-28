# CodeIgniter 4 Framework

## Catatan KP2B-Tangerang

### Base Site URL

https://p4w-ipb.id

### CPANEL
```
https://p4w-ipb.id/cpanel
user: pwipbid
pass: crestpent1p8
```
### FTP
```
host: ftp.p4w-ipb.id
user: pwipbid
pass: crestpent1p8
```

### mysql
```
user: pwipbid_admin
pass: crestpent1p8
DB: pwipbid_tangerang
```

### SSH
```
lumineon.sg.rapidplex.com:64000
user: pwipbid
pass: crestpent1p8
```

## API


### subdist
```
Show json subdist for remote select2
https://localhost/kp2b-tangerang/api/subdist |page null
https://localhost/kp2b-tangerang/api/subdist?q=abcd&page=1 |page 1 limit 10
```

### farmer
```
Show json farmer for remote select2
https://localhost/kp2b-tangerang/api/farmers |page null
https://localhost/kp2b-tangerang/api/farmers?q=abcd&page=1 |page 1 limit 10
--------------------------------------------------------------------
Show segment farmcode atau ajax farmcode
https://localhost/kp2b-tangerang/api/farmers/1 | show farmer
https://localhost/kp2b-tangerang/api/farmers/ajax?id=1 show extend farmer
```

### owners
```
Show json owners for remote select2
https://localhost/kp2b-tangerang/api/owners |page null
https://localhost/kp2b-tangerang/api/owners?q=abcd&page=1 |page 1 limit 10
```

### respondens
```
Show json respondens for remote select2
https://localhost/kp2b-tangerang/api/respondens |page null
https://localhost/kp2b-tangerang/api/respondens?q=abcd&page=1 |page 1 limit 10
```

### observation
```
Show segment atau ajax observation
https://localhost/kp2b-tangerang/api/observation/x
https://localhost/kp2b-tangerang/api/observation/ajax?id=x
```

### geojson
```
https://"HOST"/api/geo/info
https://"HOST"/api/geo/info?table=v_observations&fid=obscode&shape=obsshape&fields=ownername,cultivatorname
```

## CLI

### delete writable
```
Custom delete writable folder = "session, cache, logs, debugbar"
:\> php public\index.php cli writable delete session
:\> php public\index.php cli cache delete *.cache
```

### cache geojson
```
Cache geoJSON dengan kondisi 'sdcode'.'code' atau 'vlcode'.'code'
:\> php public\index.php cli geo cache sdcode 360308
:\> php public\index.php cli geo cache vlcode 3603082003
--------------------------------------------------------------------
Cache geoJSON foreach
:\> php public\index.php cli geo cache kecamatan
:\> php public\index.php cli geo cache kelurahan
```