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

### owners
```
https://"HOST"/api/owners
https://"HOST"/api/owners?q=aaa&page=1
```
### geojson
```
https://"HOST"/api/geo/info
https://"HOST"/api/geo/info?table=v_observations&fid=obscode&shape=obsshape&fields=ownername,cultivatorname
```

## Command Line
```
cli routes
php public\index.php "cli writable delete" "session, cache, logs, debugbar"

running sample
php public\index.php cli writable delete sessions
```