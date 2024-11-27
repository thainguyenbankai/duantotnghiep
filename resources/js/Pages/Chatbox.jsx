import React, { useState } from 'react';
import ReactDOM from 'react-dom';


const ChatBox = () => {
    const [isOpen, setIsOpen] = useState(false);

    return ReactDOM.createPortal(
        <div className={`chat-box ${isOpen ? 'open' : ''}`}>
            <div className="chat-header" onClick={() => setIsOpen(!isOpen)}>
                {isOpen ? 'Close Chat' : 'Open Chat'}
            </div>
            {isOpen && (
                <div className="chat-content">
                    <p>Hello! How can we help you?</p>
                    <textarea placeholder="Type your message..." />
                </div>
            )}
        </div>,
        document.body 
    );
};
export default ChatBox;
