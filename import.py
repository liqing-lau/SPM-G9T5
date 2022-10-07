import pandas as pd
from sqlalchemy import create_engine

# Database
host="localhost"
user="root"
password="root"
# password=""
port= 3306
database= 'ljms'

def get_connection():
    return create_engine(
        url="mysql+pymysql://{0}:{1}@{2}:{3}/{4}".format(
            user, password, host, port, database
        )
    )

if __name__ == '__main__':
  
    try:
        
        # GET THE CONNECTION OBJECT (ENGINE) FOR THE DATABASE
        engine = get_connection()
        print(
            f"Connection to the {host} for user {user} created successfully.")
    except Exception as ex:
        print("Connection could not be made due to the following error: \n", ex)

role_r = pd.read_csv(r'RawData/role.csv', engine='python', encoding='unicode_escape',)
course_r = pd.read_csv(r'RawData/courses.csv', engine='python', encoding='unicode_escape')
registration_r = pd.read_csv(r'RawData/registration.csv', engine='python', encoding='unicode_escape')
staff_r = pd.read_csv(r'RawData/staff.csv', engine='python', encoding='unicode_escape')


engine = get_connection()
conn = engine.connect()

from sqlalchemy.dialects.mysql import insert

def insert_on_duplicate(table, conn, keys, data_iter):
    insert_stmt = insert(table.table).values(list(data_iter))
    on_duplicate_key_stmt = insert_stmt.on_duplicate_key_update(insert_stmt.inserted)
    conn.execute(on_duplicate_key_stmt)


role_r.to_sql(con = engine, name = 'role', if_exists = 'append', chunksize = 1000, index = False, method = insert_on_duplicate)
course_r.to_sql(con = engine, name = 'course', if_exists = 'append', chunksize = 1000, index = False, method = insert_on_duplicate)
staff_r.to_sql(con = engine, name = 'staff', if_exists = 'append', chunksize = 1000, index = False, method = insert_on_duplicate)
# registration_r.to_sql(con = engine, name = 'registration', if_exists = 'append', chunksize = 1000, index = False, method = insert_on_duplicate)
