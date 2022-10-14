import pandas as pd
from sqlalchemy import create_engine


# Database
host="localhost"
user="root"
password=""
password=""
port= 3306
database= "ljms"

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
        print("Connection could not be made due to the following error: ", ex)


role_r = pd.read_csv(r'RawData/role.csv', engine='python', encoding='unicode_escape',)
course_r = pd.read_csv(r'RawData/courses.csv', engine='python', encoding='unicode_escape')
registration_r = pd.read_csv(r'RawData/registration.csv', engine='python', encoding='unicode_escape')
staff_r = pd.read_csv(r'RawData/staff.csv', engine='python', encoding='unicode_escape')
jobrole_r = pd.read_csv(r'RawData/jobRole.csv', engine='python', encoding='unicode_escape')
skill_r = pd.read_csv(r'RawData/skills.csv', engine='python', encoding='unicode_escape')
courseskill_r = pd.read_csv(r'RawData/courseskills.csv', engine='python', encoding='unicode_escape')
jobskill_r = pd.read_csv(r'RawData/jobskills.csv', engine='python', encoding='unicode_escape')

# for testing
lj_r = pd.read_csv(r'RawData/lj.csv', engine='python', encoding='unicode_escape')

engine = get_connection()
conn = engine.connect()

from sqlalchemy.dialects.mysql import insert

def insert_on_duplicate(table, conn, keys, data_iter):
    insert_stmt = insert(table.table).values(list(data_iter))
    on_duplicate_key_stmt = insert_stmt.on_duplicate_key_update(insert_stmt.inserted)
    conn.execute(on_duplicate_key_stmt)



jobrole_r.to_sql(con = engine, name = 'jobrole', if_exists = 'append', chunksize = 1000, index = False, method = insert_on_duplicate)
skill_r.to_sql(con = engine, name = 'skill', if_exists = 'append', chunksize = 1000, index = False, method = insert_on_duplicate)
courseskill_r.to_sql(con = engine, name = 'courseskill', if_exists = 'append', chunksize = 1000, index = False, method = insert_on_duplicate)
jobskill_r.to_sql(con = engine, name = 'jobskill', if_exists = 'append', chunksize = 1000, index = False, method = insert_on_duplicate)

# for testing
lj_r.to_sql(con = engine, name = 'lj', if_exists = 'append', chunksize = 1000, index = False, method = insert_on_duplicate)

conn.close()
engine.dispose()


