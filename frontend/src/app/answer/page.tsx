"use client";

import { Header } from "@/components/Header";
import { ResultsBox } from "@/components/ResultsBox";
import { ChatBox } from "@/components/ChatBox";
import { useState } from "react";

export default function Answer() {
    const [inputValue, setInputValue] = useState("");
    return (
        <div className="GeneralPurposeBg min-h-screen ">
            <Header/>
            <div className="flex items-start justify-center">
                <ChatBox />
                <ResultsBox />
            </div>
        </div>
    )
}