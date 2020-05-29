from query_executor import MySQLExecutor 

db = MySQLExecutor('localhost','root','')

schemas = {}


def type_sql2py(t: str):
    t = t.lower()
    if 'int' in t:
        return int
    if 'blob' in t or 'binary' in t:
        return bytes
    if 'float' in t or 'double' in t or 'decimal' in t:
        return float
    #if 'time' in t or 'date' in t:
    #    return datetime
    return str


#grep databases/tables
for schema, table in db.execute(
                        columns=['TABLE_SCHEMA', 'TABLE_NAME'], 
                        column_types=[str,str],
                        schema="INFORMATION_SCHEMA",
                        table="TABLES",
                        raw_condition="TABLE_TYPE <> 'SYSTEM VIEW'"):
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
        #grep column info
        for name, _type in db.execute(
                        columns=['COLUMN_NAME', 'COLUMN_TYPE'], 
                        column_types=[str, type_sql2py],
                        schema="INFORMATION_SCHEMA",
                        table="COLUMNS",
                        raw_condition=f"TABLE_NAME='{table}' and TABLE_SCHEMA='{schema}'"):
            t['column_names'].append(name)
            t['column_types'].append(_type)

#grep rows
for schema in schemas:
    for table in schemas[schema]:
        t = schemas[schema][table]
        for row in db.execute(t['column_names'], t['column_types'], schema, table):
            t['rows'].append(row)

from pprint import pprint
pprint(schemas['edi'])

