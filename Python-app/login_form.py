import tkinter as tk
import os
from PIL import Image, ImageTk
import time

main_panel = None  # Initialize main_panel

def update_clock():
    current_time = time.strftime('%H:%M:%S')
    clock_label.config(text=current_time)
    
    # Get the current date and day of the week
    current_date = time.strftime('%Y-%m-%d')
    current_day = time.strftime('%A')  # %A returns the full day name
    date_label.config(text=current_date)
    day_label.config(text=current_day)
    
    root.after(1000, update_clock)

def login():
    username = username_entry.get()
    password = password_entry.get()

    if username == "admin" and password == "password":
        admin_panel()
    else:
        login_status_label.config(text="Login Failed", fg="red")

def admin_panel():
    # Remove login elements
    username_label.grid_remove()
    password_label.grid_remove()
    username_entry.grid_remove()
    password_entry.grid_remove()
    login_button.grid_remove()
    login_status_label.grid_remove()

    # Create and configure the buttons for shutdown, restart, and sleep
    shutdown_button = tk.Button(main_panel, text="Shutdown", command=shutdown, font=("Arial", 10), bg="red", fg="white")
    shutdown_button.grid(row=5, column=2, padx=5, pady=5)

    restart_button = tk.Button(main_panel, text="Restart", command=restart, font=("Arial", 10), bg="red", fg="white")
    restart_button.grid(row=6, column=2, padx=5, pady=5)

    sleep_button = tk.Button(main_panel, text="Sleep", command=sleep, font=("Arial", 10), bg="red", fg="white")
    sleep_button.grid(row=7, column=2, padx=5, pady=5)

def logout():
    # Destroy the current main_panel (admin panel)
    main_panel.destroy()

    # Recreate and show the login form
    show_login_form()

def show_login_form():
    global main_panel
    main_panel = tk.Frame(root)
    main_panel.place(relx=0.5, rely=0.5, anchor="center")

    # Create a header label
    header_label = tk.Label(main_panel, text="Computer Laboratory AMS", font=("Arial", 24), bg="black", fg="white")
    header_label.grid(row=0, column=1, padx=10, pady=10)

    # Center the login elements using grid
    username_label.grid(row=1, column=0, sticky="w", padx=10, pady=10)
    password_label.grid(row=2, column=0, sticky="w", padx=10, pady=10)
    username_entry.grid(row=1, column=1, padx=10, pady=10)
    password_entry.grid(row=2, column=1, padx=10, pady=10)
    login_button.grid(row=3, column=1, padx=10, pady=20)
    login_status_label.grid(row=4, column=1, padx=10, pady=10)
    
def shutdown():
    os.system("shutdown /s /t 0")

def restart():
    os.system("shutdown /r /t 0")

def sleep():
    os.system("rundll32.exe powrprof.dll,SetSuspendState 0,1,0")

# Create and configure the root window
root = tk.Tk()
root.title("Computer Laboratory AMS")
root.bind('<Return>', login)

root.wm_state('zoomed')

# Load a background image
bg_image = Image.open("C:/xampp/htdocs/PUP-CL-AMS-main/Python-app/pupbg.jpg")
bg_photo = ImageTk.PhotoImage(bg_image)
bg_label = tk.Label(root, image=bg_photo)
bg_label.place(relwidth=1, relheight=1)

# Create a main panel
main_panel = tk.Frame(root)
main_panel.place(relx=0.5, rely=0.5, anchor="center")

# Create a header label
header_label = tk.Label(main_panel, text="Computer Laboratory AMS", font=("Arial", 24), bg="black", fg="white")
header_label.grid(row=0, column=1, padx=10, pady=10)

# Create and configure the login form
username_label = tk.Label(main_panel, text="Username", font=("Arial", 18), bg="white", fg="black")
password_label = tk.Label(main_panel, text="Password", font=("Arial", 18), bg="white", fg="black")
username_entry = tk.Entry(main_panel, font=("Arial", 16))
username_entry.bind('<Return>', login)  # Bind Enter key to login function
password_entry = tk.Entry(main_panel, show="*", font=("Arial", 16))
login_button = tk.Button(main_panel, text="Login", command=login, font=("Arial", 16), bg="red", fg="white")
login_status_label = tk.Label(main_panel, text="", font=("Arial", 16), bg="white", fg="black")

username_label.grid(row=1, column=0, sticky="w", padx=10, pady=10)
password_label.grid(row=2, column=0, sticky="w", padx=10, pady=10)
username_entry.grid(row=1, column=1, padx=10, pady=10)
password_entry.grid(row=2, column=1, padx=10, pady=10)
login_button.grid(row=3, column=1, padx=10, pady=20)
login_status_label.grid(row=4, column=1, padx=10, pady=10)

# Create and configure the clock label
clock_label = tk.Label(main_panel, text="", font=("Arial", 24), bg="black", fg="white")
clock_label.grid(row=5, column=1, padx=10, pady=10)

# Create and configure the date and day labels
date_label = tk.Label(main_panel, text="", font=("Arial", 18), bg="black", fg="white")
date_label.grid(row=6, column=1, padx=10, pady=5)

day_label = tk.Label(main_panel, text="", font=("Arial", 14), bg="black", fg="white")
day_label.grid(row=7, column=1, padx=10, pady=5)

shutdown_button = tk.Button(main_panel, text="Shutdown", command=shutdown, font=("Arial", 10), bg="red", fg="white")
shutdown_button.grid(row=5, column=2, padx=5, pady=5)

restart_button = tk.Button(main_panel, text="Restart", command=restart, font=("Arial", 10), bg="red", fg="white")
restart_button.grid(row=6, column=2, padx=5, pady=5)

sleep_button = tk.Button(main_panel, text="Sleep", command=sleep, font=("Arial", 10), bg="red", fg="white")
sleep_button.grid(row=7, column=2, padx=5, pady=5)


# Update the clock
update_clock()

root.mainloop()
