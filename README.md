# Proyecto ZSSN 

## (Red Social de Supervivencia Zombi). 



El mundo tal como lo conocemos ha caído en un escenario apocalíptico. Un virus creado en laboratorio está transformando a seres humanos y animales en zombis hambrientos de carne fresca.
Usted, como miembro de la resistencia zombie (y el último sobreviviente que sabe codificar), fue designado para desarrollar un sistema para compartir recursos entre humanos no infectados.



## RUTAS API
### Todos los supervivientes:
- GET     api/supervivientes/

### Buscar superviviente por id:
- GET     api/supervivientes/{id}

### Actualizar Mi Ubicación:
- PUT     api/supervivientes/{id}
```
{
    "latitud": "10.1",
    "longitud": "9.1"
}
```
### Nuevo Superviviente:
- POST     api/supervivientes/
```
{
    "nombre": "Erick Pineda",
    "edad": "37",
    "genero": "Hombre",
    "latitud": "1414",
    "longitud": "1414",
    "recursos": [
        {
            "item": "1",
            "cantidad": "4"
        },
        {
            "item": "2",
            "cantidad": "5"
        },
        {
            "item": "4",
            "cantidad": "5"
        }
    ]
}
```
### Reportar Infectado:
- POST     api/supervivientes/reportarinfectado/
```
{
    "supervivientereporte": "8",
    "supervivientereportado": "1"
}
```
### Transacciones de articulos
- POST     api/supervivientes/transacciones/
```
{
    "sobreviviente1_id": "10",
    "sobreviviente2_id": "3",
    "sobreviviente1": [
        {
            "item": "1",
            "cantidad": "1"
        }
    ],
    "sobreviviente2": [
        {
            "item": "3",
            "cantidad": "1"
        },
        {
            "item": "4",
            "cantidad": "2"
        }
    ]
}
```
## API PARA REPORTES
### Informe de Sobrevivientes infectados y no infectados
	- GET     api/supervivientes/reportes/infectados/

### Informe de Recursos con la cantidad promedio de cada uno
	- GET     api/supervivientes/reportes/items/

### Informe de Puntos y Recursos perdidos por infectados
	- GET     api/supervivientes/reportes/puntosporintfectado/


