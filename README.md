# Laravel Rest API simple exercise 

Following we have a sequence of requests that will be used to test the API.

## Reset de las cuentas

```
POST /reset

200 OK
```


## Obtener el balance de una cuenta no existente

```
GET /balance?account_id=1234

404 0
```

## Crear cuenta con un balance inicial

```
POST /event {"type":"deposit", "destination":"100", "amount":10}

201 {"destination": {"id":"100", "balance":10}}
```

## Hacer un depósito en una cuenta existente

```
POST /event {"type":"deposit", "destination":"100", "amount":10}

201 {"destination": {"id":"100", "balance":20}}
```

## Obtener el balance de una cuenta no existente

```
GET /balance?account_id=100

200 20
```

## Retirar depósito de una cuenta no existente

```
POST /event {"type":"withdraw", "origin":"200", "amount":10}

404 0
```

## Retirar depósito de cuenta existente

```
POST /event {"type":"withdraw", "origin":"100", "amount":5}

201 {"origin": {"id":"100", "balance":15}}
```

## Transferencia desde una cuenta existente

```
POST /event {"type":"transfer", "origin":"100", "amount":15, "destination":"300"}

201 {"origin": {"id":"100", "balance":0}, "destination": {"id":"300", "balance":15}}
```

## Transferencia desde una cuenta no existente

```
POST /event {"type":"transfer", "origin":"200", "amount":15, "destination":"300"}

404 0
```
