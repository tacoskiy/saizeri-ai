"use client";

import { Header } from "@/components/Header";
import { ResultsBox } from "@/components/ResultsBox";
import { ChatBox } from "@/components/ChatBox";

export default function Answer() {
    return (
        <div className="GeneralPurposeBg min-h-screen ">
            <Header/>
            <div className="flex items-start justify-center gap-16">
                <ChatBox />
                <ResultsBox/>
            </div>
        </div>
    )
}