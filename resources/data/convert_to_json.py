import pandas as pd
import json

# Load the Excel file
excel_file = 'dialogue.xlsx'  # Change this to your Excel file name
sheet_name = 0  # Adjust if your data is not in the first sheet

# Load the Excel file into a DataFrame
df = pd.read_excel(excel_file, sheet_name=sheet_name)

# Define a function to convert the DataFrame to JSON
def convert_to_json(df):
    dialogue_list = []

    for _, row in df.iterrows():
        entry = {
            "id": row["ID"],
            "character": row["Character"],
            "type": row["Type"],
            "content": row["Content"],
            "background": row["Background"],
            "emotion": row["Emotion"],
        }

        if "Points" in df.columns and pd.notna(row["Points"]):
            entry["points"] = int(row["Points"])

        if "Choices" in df.columns and pd.notna(row["Choices"]):
            choices = []
            for choice in row["Choices"].split(';'):
                choice = choice.split("->")
                if len(choice) < 2:
                    print("Illegal choice: " + str(choice))
                    continue
                text, destination = choice
                choices.append({"text": text.strip(), "destination_id": int(destination.strip())})
            entry["choices"] = choices

        if "Next" in df.columns and pd.notna(row["Next"]):
            entry["next"] = int(row["Next"])

        if "Background" in df.columns and pd.notna(row["Background"]):
            entry["background"] = row["Background"]

        if "Emotion" in df.columns and pd.notna(row["Emotion"]):
            entry["emotion"] = row["Emotion"]
        else:
             entry["emotion"] = "default"

        if "Location" in df.columns and pd.notna(row["Location"]):
            entry["location"] = row["Location"]

        dialogue_list.append(entry)

    return dialogue_list

# Convert the DataFrame to JSON
dialogue_json = convert_to_json(df)

# Save the JSON to a file
output_file = 'dialogue.json'
with open(output_file, 'w') as f:
    json.dump(dialogue_json, f, indent=4)

print(f"JSON file saved as {output_file}")
