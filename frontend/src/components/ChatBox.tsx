"use client";
import Image from "next/image";
import Link from "next/link";
import { useState, useRef, useEffect } from "react";

type Message = {
  id: number;
  text: string;
  sender: "user" | "ai";
};

type ChatBoxProps = {
  input: string;
  setInput: React.Dispatch<React.SetStateAction<string>>;
};


export function ChatBox({ input, setInput }: ChatBoxProps) {
  const [messages, setMessages] = useState<Message[]>([]);
  const bottomRef = useRef<HTMLDivElement>(null);

  useEffect(() => {
    bottomRef.current?.scrollIntoView({ behavior: "smooth" });
  }, [messages]);

  const sendMessage = () => {
    if (!input.trim()) return;

    // ユーザーのメッセージを追加
    setMessages((prev) => [
      ...prev,
      { id: Date.now(), text: input, sender: "user" },
    ]);
    setInput("");

    // AIの返信サンプル
    setTimeout(() => {
      setMessages((prev) => [
        ...prev,
        { id: Date.now(), text: "これはAIの返信です", sender: "ai" },
      ]);
    }, 500);
  };

  return (
    <div className="relative flex flex-col items-center justify-center gap-4 p-4">
      <p className="text-3xl font-bold text-green">チャット内容</p>

      <div className="flex flex-col w-[617px] h-[580px] bg-white border-4 border-green rounded-3xl pt-4 px-4 pb-20 overflow-y-auto ">
        {messages.map((msg) => (
          <div
            key={msg.id}
            className={`flex mb-2 ${
              msg.sender === "user" ? "justify-end" : "justify-start"
            }`}
          >
            <div
              className={`px-4 py-2 rounded-lg max-w-[70%] ${
                msg.sender === "user"
                  ? "bg-green text-white rounded-br-none"
                  : "bg-gray-200 text-black rounded-bl-none"
              }`}
            >
              {msg.text}
            </div>
          </div>
        ))}
        <div ref={bottomRef} />
      </div>

      <div className="absolute bottom-10 left-1/2 transform -translate-x-1/2 flex gap-3">
        <input
          type="text"
          placeholder="Textで入力してください"
          className="w-108 h-13 pl-6 bg-gray-100 rounded-xl font-bold"
          value={input}
          onChange={(e) => setInput(e.target.value)}
          onKeyDown={(e) => e.key === "Enter" && sendMessage()}
        />

        <button
          className="flex items-center justify-center w-13 h-13 bg-gray-100 rounded-full"
          onClick={sendMessage}
        >
          <Image src="/Mikegray.svg" alt="マイク" width={25} height={25} />
        </button>

        <button className="flex justify-center items-center text-4xl w-13 h-13 bg-gray-100 rounded-full text-Gray">
          <Link href="/">
            <p>×</p>
          </Link>
        </button>
      </div>
    </div>
  );
}
