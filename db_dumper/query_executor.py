
class BaseQueryExecutor:
    def execute(self, query):
        pass

class MySQLExecutor(BaseQueryExecutor):
    def __init__(self, host, user, password):
        #pip3 install mysql-connector
        import mysql.connector

        self.conn = mysql.connector.connect(
            host=host,
            user=user,
            passwd=password
        )

    def execute(self, query):
        cursor = self.conn.cursor()
        res = cursor.execute(query)
        return cursor.fetchall()

