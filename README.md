```sh
curl --user admin:admin --data-binary '{"jsonrpc": "1.0", "id": "curltest", "method": "getrpcinfo", "params": []}' -H 'content-type: text/plain;' http://127.0.0.1:18332/

curl --data-binary '{"id":"myquery","method":"getaddressbalance","params":["mmGkwmzwVQj2sRsBvjt3mKRuE7R9EXMSHG"]}' http://admin:admin@127.0.0.1:7777
```