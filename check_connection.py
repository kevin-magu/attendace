import subprocess
import mysql.connector

def get_mac_addresses():
    command = "iw dev wlan0 station dump"
    process = subprocess.Popen(command, stdout=subprocess.PIPE, shell=True)
    output, error = process.communicate()

    if error:
        print("Error:", error)
        return

    mac_addresses = []
    lines = output.decode().split("\n")

    for line in lines:
        if "Station" in line:
            mac_address = line.split(" ")[1]
            mac_addresses.append(mac_address)

    return mac_addresses

def store_mac_addresses_in_database(mac_addresses):
    try:
        # Connect to your MySQL database (replace with your connection details).
        conn = mysql.connector.connect(
            host="localhost",
            user="root",
            password="root",
            database="attendace"
        )
        
        cursor = conn.cursor()

        # Create a table if it doesn't exist (you may need to adjust the schema).
        
        # Insert MAC addresses into the database.
        for mac_address in mac_addresses:
            insert_query = "INSERT INTO mac_test (mac) VALUES (%s)"
            cursor.execute(insert_query, (mac_address,))

        # Commit the changes and close the connection.
        conn.commit()
        conn.close()

    except mysql.connector.Error as err:
        print("MySQL error:", err)

def main():
    mac_addresses = get_mac_addresses()

    if mac_addresses:
        print("Connected devices:")
        for mac_address in mac_addresses:
            print(mac_address)

        # Store the MAC addresses in the MySQL database.
        store_mac_addresses_in_database(mac_addresses)
    else:
        print("No devices connected.")

if __name__ == "__main__":
    main()
