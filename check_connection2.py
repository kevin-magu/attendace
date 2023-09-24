import subprocess
import re

def get_mac_address(interface):
    try:
        # Use the 'ifconfig' command to retrieve network interface information.
        command = f"ifconfig {interface}"
        output = subprocess.check_output(command, shell=True, text=True)
        
        # Use a regular expression to search for the MAC address in the output.
        mac_pattern = r"ether\s+([0-9A-Fa-f:]+)"
        match = re.search(mac_pattern, output)

        if match:
            mac_address = match.group(1)
            return mac_address

    except subprocess.CalledProcessError:
        pass

    return None

if __name__ == "__main__":
    # Replace 'wlan0' with the name of your Wi-Fi interface.
    interface = "wlan0"
    
    mac_address = get_mac_address(interface)
    
    if mac_address:
        print(f"MAC Address of {interface}: {mac_address}")
    else:
        print(f"MAC Address of {interface} not found.")
