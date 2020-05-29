from query_executor import MySQLExecutor 

db = MySQLExecutor('localhost','root','')

ALL_SCHEMAS = "select distinct TABLE_SCHEMA, TABLE_NAME from information_schema.TABLES where TABLE_TYPE <> 'SYSTEM VIEW'"
ALL_COLUMNS = "select COLUMN_NAME,COLUMN_TYPE from INFORMATION_SCHEMA.COLUMNS where table_name='{table}' and TABLE_SCHEMA='{schema}' order by ORDINAL_POSiTION;"
ALL_VALUES  = "select * from {schema}.{table}"
schemas = {}

#grep databases/tables
for schema, table in db.execute(ALL_SCHEMAS):
    if schema not in schemas:
        schemas[schema] = {}
    schemas[schema][table] = {
        'column_names':[], 
        'column_types':[], 
        'rows':[]
        }
        
#grep columns of each table
for schema in schemas:
    for table in schemas[schema]:
        t = schemas[schema][table]
        query = ALL_COLUMNS.format(schema=schema, table=table)
        #grep column info
        for name, _type in db.execute(query):
            t['column_names'].append(name)
            t['column_types'].append(_type)

#grep rows
for schema in schemas:
    for table in schemas[schema]:
        query = ALL_VALUES.format(schema=schema, table=table)
        for row in db.execute(query):
            t['rows'].append(row)

from pprint import pprint
pprint(schemas['edi'])

