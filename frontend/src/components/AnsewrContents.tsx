import { ResultsBox } from "@/components/ResultsBox";
import { ChatBox } from "@/components/ChatBox";
import { useState } from "react";
export function AnsewrContents() {
    const [inputValue, setInputValue] = useState("");
    return (
        <div className="flex items-start justify-center">
            <ChatBox input={inputValue} setInput={setInputValue}/>
            <ResultsBox />
        </div>
    );
}