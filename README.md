
## API-Lade-Laravel

 API-Lade-Laravel provee las funciones básicas de consumo de recursos de una Base de Datos SQL Server
 a cualquier tipo de cliente. 
 
## Rutas
El archivo ``` routes/api.php ``` contiene las rutas del proyecto.
Aquí se configuran los accesos, los controladores y las funciones que se ejecutan
cuando se dispara una URL.


Las Rutas que requieren autentificación, se definen dentro del siguiente bloque de código

```
...
//Protected Routes
Route::group(['middleware' => ['auth:api']],function() {
   //Rutas protegidas 
});
...
```

####Rutas Protegidas

* Ruta para obtener los productos por parámetros
    * conExistencia (Obligatorio)
```
...
    Route::get('products/getProducts/{conExistencia}/{descripcion?}/{clase?}/{lugar?}', 'ProductsController@getProducts');
...
```
* Ruta para obtener la orden de un producto por número de pedido
    * numeroPedido (Obligatorio)
```
...
    Route::get('products/getProductsOrder/{numeroPedido}', 'ProductsController@getProductsOrder');
...
```

* Ruta para obtener las órdenes por email del vendedor
    * email (Obligatorio)
```
...
    Route::get('orders/getOrders/{email}/{numeroPedido?}/{status?}/{anio?}/{mes?}', 'OrdersController@getOrders');
...
```

* Ruta para obtener el detalle de la orden por número de pedido
    * numeroPedido (Obligatorio)
```
...
    Route::get('orders/getOrderDetail/{numeroPedido}', 'OrdersController@getOrderDetail');
...
```

* Ruta para obtener el detalle de los clientes
   
```
...
    Route::get('clients/getClients', 'ClientsController@getClients');
...
```

####Rutas sin seguridad:

En el proyecto existe una ruta sin seguridad, pero puede haber múltiples, estás se definen fuera del bloque de código visto en la sección anterior.
La ruta sin seguridad corresponde a */login* esta ruta se encarga de recibir el token de *Firebase* que proporciona el Front-End.
```
...
    //Login Route
    Route::post('login','Auth\LoginController@login');
...
```

##Controladores

Existen 4 controladores clave en el proyecto estos son:
* ClientsController - Se encarga de atender las peticiones realizadas por la url */clients*
* LoginController - Se encarga de atender las peticiones realizadas por la url */login*
* OrdersController - Se encarga de atender las peticiones realizadas por la url */orders*
* ProductsController - Se encarga de atender las peticiones realizadas por la url */products*

##Autentificación

El proceso de autentificación lo prove [Firebase](https://firebase.google.com/docs/auth/web/firebaseui) de Google por medio de un [SDK](https://github.com/kreait/laravel-firebase) para Laravel.

El proceso de autentificación se define en la siguiente imágen:

![](https://miro.medium.com/max/1400/1*_AlSZ1geiCSVGXBMJXAWCg.png)

Básicamente el Front-End solicita un token de acceso a Firebase Auth, este token es retornado al Front-End

La petición se realiza inmediatamente al iniciar sesión con Firebase:

Ejemplo JS:
```
user.getIdToken().then(function(accessToken) {
   //Realizar petición aquí
})
```
Ejemplo de petición a la url */login* utilizando AXIOS

```
let post = {
   "Firebasetoken": accessToken
}

axios.post(`${api_url}/api/login`,post).then((response) => {
    console.log(response.data)
})
```

Para que luego se envíe mediante una petición a Laravel.

*Notar que ```${api_url}``` corresponde a la url de la API del servidor en producción o en Dev.

Laravel a su vez confirma que el token pertenece a un cliente de Firebase que busca en la Base de Datos de SQL Server.

Es importante mencionar que la autentificación será exitosa si el usuario almacenado en Firebase existe también el la BD de SQL Server.

De existir se regresa una respuesta con un token generado por [Passport](https://laravel.com/docs/7.x/passport).

Ejemplo de la respuesta exitosa:

```
{
"id":1,
"access_token":"eyhdfRlD92983XIRBCYcEyt4ic6Hi1sWBtbAk5miTQJmlAx3...",
"token_type":"Bearer",
"expires_at":"2020-08-03 17:17:09"
}
```
Una vez que se regresa el *access_token* es importante almacenarlo en el Front-End en *LocalStorage,LocalSession,Cookies,etc...*
El token debe incluírse como encabezado en todas las peticiones que se realicen.

Ejemplo utilizando JS:

```
headers: {
    'Authorization': `Bearer ${token}` 
}
```

Ejemplo de respuesta exitosa si se específica el token como header de 'Authorization' en la petición get de la url */api/products/getProductsOrder/23731*:

```
[
  ...
  {
    "numeroPedido": "23731",
    "claveProducto": "4896-J1",
    "claseProducto": "FORMICA",
    "cantidadProductos": "1.0",
    "valorProducto": "1250.25",
    "ivaProducto": "16.0",
    "descripcionProducto": "METALLIC BRUSHED ALUM.",
    "UNIDAD": "PZA"
  }
  ...
]
```

##Ejemplo de petición

Método get: */api/products/getProductsOrder/12345*

Regresa:
```

[
  {
    "numeroPedido": "12345",
    "claveProducto": "PR-390-19",
    "claseProducto": "ARTECOLA",
    "cantidadProductos": "3.0",
    "valorProducto": "1579.8499999999999",
    "ivaProducto": "16.0",
    "descripcionProducto": "sddsddsdsds",
    "UNIDAD": "PZA"
  },
  {
    "numeroPedido": "12345",
    "claveProducto": "4896-J1",
    "claseProducto": "FORMICA",
    "cantidadProductos": "1.0",
    "valorProducto": "1250.25",
    "ivaProducto": "16.0",
    "descripcionProducto": "dsdsdsdd",
    "UNIDAD": "PZA"
  },
  {
    "numeroPedido": "12345",
    "claveProducto": "5722-30",
    "claseProducto": "GL",
    "cantidadProductos": "7.0",
    "valorProducto": "840.0",
    "ivaProducto": "16.0",
        "descripcionProducto": "dsdsdsd",
    "UNIDAD": "PZA"
  },
  {
    "numeroPedido": "12345",
    "claveProducto": "5726-30",
    "claseProducto": "GL",
    "cantidadProductos": "23.0",
    "valorProducto": "840.0",
    "ivaProducto": "16.0",
    "descripcionProducto": "dssddsdds",
    "UNIDAD": "PZA"
  }
]

```

##La tabla Users
Dentro de la BD de SQL Server existe una tabla llamada *users* a su vez esta tabla contiene
una columna llamada *firebaseUID* este identificador debe ser el mismo que el ID del usuario de Firebase.

De no coincidir marcaría error al intentar iniciar sesión.

Las otras columnas como email, name, etc. pueden ser diferentes a los datos almacenados en Firebase, sin embargo se recomienda
que coincidan para evitar incoherencias en la información.

##Configuración de Firebase
Ubicar el archivo *firebase_credentials.json* en la raíz del proyecto para editar la configuración

Sin esta configuración no será posible autenticar los usuarios con Firebase. [Más Información](https://firebase.google.com/docs/admin/setup#initialize_the_sdk)

Ejemplo del archivo:

```
{
  "type": "service_account",
  "project_id": "test",
  "private_key_id": "09202a*******************",
  "private_key": "-----BEGIN PRIVATE KEY-----\n ****************************"
  "client_email": "firebase-adminsdk-sv*******************",
  "client_id": "116*******************",
  "auth_uri": "https://accounts.google.com/o/oauth2/auth",
  "token_uri": "https://oauth2.googleapis.com/token",
  "auth_provider_x509_cert_url": "https://www.googleapis.com/oauth2/v1/certs",
  "client_x509_cert_url": "https://www.googleapis.com/robot/v1/metadata/x509/fireba*******************74.iam.gserviceaccount.com"
}

```