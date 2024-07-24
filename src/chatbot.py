from chatterbot import ChatBot
from chatterbot.trainers import ChatterBotCorpusTrainer

chatbot = ChatBot('AdaptBot')
trainer = ChatterBotCorpusTrainer(chatbot)
trainer.train("chatterbot.corpus.english")

def get_bot_response(user_input):
    return str(chatbot.get_response(user_input))

# In your GUI:
def open_chat_window():
    chat_window = tk.Toplevel()
    chat_window.title("Adapt Support Chat")
    
    chat_log = tk.Text(chat_window, state='disabled')
    chat_log.pack()
    
    input_field = tk.Entry(chat_window)
    input_field.pack()
    
    def send_message():
        user_input = input_field.get()
        bot_response = get_bot_response(user_input)
        chat_log.config(state='normal')
        chat_log.insert(tk.END, f"You: {user_input}\n")
        chat_log.insert(tk.END, f"AdaptBot: {bot_response}\n")
        chat_log.config(state='disabled')
        input_field.delete(0, tk.END)
    
    send_button = tk.Button(chat_window, text="Send", command=send_message)
    send_button.pack()